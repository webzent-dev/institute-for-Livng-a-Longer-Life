<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

/**
 * One editor screen for every section-based public page (About, Collaborators,
 * Intro Videos, Store, Contact, FAQ, Help Centre, Testimonials). The editable
 * shape of each page comes from config/page_content.php, so the form and the
 * save both stay in step with a single definition.
 */
class PageContentController extends Controller
{
    public function index(string $page)
    {
        $schema = $this->schema($page);

        $sections = PageContent::where('page_key', $page)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key');

        return view('admin.content_management.page', compact('page', 'schema', 'sections'));
    }

    public function update(Request $request, string $page)
    {
        $schema = $this->schema($page);

        $request->validate([
            'sections'              => 'required|array',
            'sections.*.heading'    => 'nullable|string|max:255',
            'sections.*.subheading' => 'nullable|string|max:255',
            'sections.*.body'       => 'nullable|string',
            'sections.*.status'     => 'nullable|in:active,inactive',
        ]);

        $sortOrder = 0;

        // Driven by the schema, not by the request, so unknown keys are never saved.
        foreach ($schema['sections'] as $sectionKey => $sectionSchema) {
            $input = $request->input("sections.$sectionKey");
            if (!is_array($input)) {
                continue;
            }

            $sortOrder++;

            PageContent::updateOrCreate(
                ['page_key' => $page, 'section_key' => $sectionKey],
                [
                    'heading'    => $input['heading'] ?? null,
                    'subheading' => $input['subheading'] ?? null,
                    'body'       => $input['body'] ?? null,
                    'items'      => $this->cleanItems((array) ($input['items'] ?? []), $sectionSchema['items'] ?? []),
                    'meta'       => $this->cleanMeta((array) ($input['meta'] ?? [])),
                    'status'     => $input['status'] ?? 'active',
                    'sort_order' => $sortOrder,
                ]
            );
        }

        return redirect()->route('admin.content.page', $page)
            ->with('success', $schema['label'] . ' page content has been updated successfully.');
    }

    private function schema(string $page): array
    {
        return config("page_content.pages.$page") ?? abort(404);
    }

    /**
     * Drop blank repeater rows an admin left empty, so the page never renders empty cards.
     * A list schema with `fields` holds rows of named inputs; one without holds plain strings.
     */
    private function cleanItems(array $items, array $listSchemas): array
    {
        $clean = [];

        foreach ($listSchemas as $listKey => $listSchema) {
            $rows = (array) ($items[$listKey] ?? []);

            if (empty($listSchema['fields'])) {
                $clean[$listKey] = array_values(array_filter(array_map('trim', array_map('strval', $rows)), 'strlen'));
                continue;
            }

            $fieldKeys = array_keys($listSchema['fields']);

            $rows = array_filter($rows, function ($row) use ($fieldKeys) {
                foreach ($fieldKeys as $key) {
                    if (filled($row[$key] ?? null)) {
                        return true;
                    }
                }
                return false;
            });

            $clean[$listKey] = array_values(array_map(function ($row) use ($fieldKeys) {
                $cleanRow = [];
                foreach ($fieldKeys as $key) {
                    $cleanRow[$key] = trim((string) ($row[$key] ?? ''));
                }
                return $cleanRow;
            }, $rows));
        }

        return $clean;
    }

    private function cleanMeta(array $meta): array
    {
        return array_filter(
            array_map(fn ($v) => is_string($v) ? trim($v) : $v, $meta),
            fn ($v) => $v !== null && $v !== ''
        );
    }
}
