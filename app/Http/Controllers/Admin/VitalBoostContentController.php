<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VitalBoostContent;
use Illuminate\Http\Request;

class VitalBoostContentController extends Controller
{
    /**
     * Which repeatable lists each section owns. Keeps save() from trusting whatever
     * keys arrive in the request.
     */
    private const SECTION_ITEM_KEYS = [
        'hero'     => [],
        'benefits' => ['cards'],
        'booster'  => ['facts', 'ingredients'],
        'usage'    => ['stats', 'steps', 'powder_points'],
        'cta'      => [],
    ];

    public function index()
    {
        $sections = VitalBoostContent::orderBy('sort_order')->get()->keyBy('section_key');

        return view('admin.content_management.vital_boost', compact('sections'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'sections'                        => 'required|array',
            'sections.*.heading'              => 'nullable|string|max:255',
            'sections.*.subheading'           => 'nullable|string|max:255',
            'sections.*.body'                 => 'nullable|string',
            'sections.*.status'               => 'nullable|in:active,inactive',
        ]);

        $sortOrder = 0;

        foreach (self::SECTION_ITEM_KEYS as $sectionKey => $listKeys) {
            $input = $request->input("sections.$sectionKey");
            if (!is_array($input)) {
                continue;
            }

            $sortOrder++;

            VitalBoostContent::updateOrCreate(
                ['section_key' => $sectionKey],
                [
                    'heading'    => $input['heading'] ?? null,
                    'subheading' => $input['subheading'] ?? null,
                    'body'       => $input['body'] ?? null,
                    'items'      => $this->cleanItems($input['items'] ?? [], $sectionKey, $listKeys),
                    'meta'       => $this->cleanMeta($input['meta'] ?? []),
                    'status'     => $input['status'] ?? 'active',
                    'sort_order' => $sortOrder,
                ]
            );
        }

        return redirect()->route('admin.content.vital-boost')
            ->with('success', 'Vital Boost page content has been updated successfully.');
    }

    /**
     * Drop blank repeater rows an admin left empty, so the page never renders empty cards.
     * The benefits section stores a flat list; the others store named lists.
     */
    private function cleanItems(array $items, string $sectionKey, array $listKeys): array
    {
        if ($sectionKey === 'benefits') {
            $cards = array_values(array_filter(
                $items['cards'] ?? [],
                fn ($card) => filled($card['title'] ?? null) || filled($card['description'] ?? null)
            ));

            return array_map(fn ($card) => [
                'icon'        => trim($card['icon'] ?? 'heart') ?: 'heart',
                'title'       => trim($card['title'] ?? ''),
                'description' => trim($card['description'] ?? ''),
            ], $cards);
        }

        $clean = [];

        foreach ($listKeys as $listKey) {
            $rows = $items[$listKey] ?? [];

            if ($listKey === 'stats') {
                $rows = array_values(array_filter($rows, fn ($r) => filled($r['value'] ?? null) || filled($r['label'] ?? null)));
                $clean[$listKey] = array_map(fn ($r) => [
                    'value' => trim($r['value'] ?? ''),
                    'label' => trim($r['label'] ?? ''),
                    'sub'   => trim($r['sub'] ?? ''),
                ], $rows);
                continue;
            }

            // Plain string lists: facts, ingredients, steps, powder_points
            $clean[$listKey] = array_values(array_filter(array_map('trim', (array) $rows), 'strlen'));
        }

        return $clean;
    }

    private function cleanMeta(array $meta): array
    {
        return array_filter(array_map(fn ($v) => is_string($v) ? trim($v) : $v, $meta), fn ($v) => $v !== null && $v !== '');
    }
}
