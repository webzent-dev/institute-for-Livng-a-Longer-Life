<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'membership_name',
        'membership_price',
        'discount_percent',
        'membership_period',
        'membership_description',
        'membership_features',
        'membership_benefits',
        'popular'
    ];

    public function createMembership($request)
    {
        $membership = new Membership();
        $membership->membership_name = $request->membership_name;
        $membership->membership_price = $request->membership_price;
        $membership->discount_percent = $request->discount_percent ?? 0;
        $membership->membership_period = $request->membership_period;
        $membership->membership_description = $request->membership_description;
        $membership->membership_features = $request->membership_features;
        $membership->membership_benefits = $request->membership_benefits;
        return  $membership->save();
    }

    public function updateMembership($request,$id)
    {
        $membership = Membership::findOrFail($request->id);

        $membership->membership_name = $request->membership_name;
        $membership->membership_price = $request->membership_price;
        $membership->discount_percent = $request->discount_percent ?? 0;
        $membership->membership_period = $request->membership_period;
        $membership->membership_description = $request->membership_description;
        $membership->membership_features = $request->membership_features;
        $membership->membership_benefits = $request->membership_benefits;
        return  $membership->save();
    }

    public function makePopular($id, $popular_value)
    {
        $membership =  Membership::findOrFail($id);
        $membership->popular = $popular_value;
        $membership->update();
        return true;
    }

    /**
     * Price normalised to a yearly figure, so plans billed over different periods
     * can be ranked against each other.
     *
     * Comparing the raw price would rank a $20/month plan below a $150/year one,
     * when it actually costs $240 a year. Lifetime outranks everything.
     */
    public function annualisedPrice(): float
    {
        return match (strtolower((string) $this->membership_period)) {
            'month'    => (float) $this->membership_price * 12,
            'lifetime' => INF,
            default    => (float) $this->membership_price,
        };
    }

    /**
     * How this plan compares to the one a member currently holds.
     *
     * @return string One of: current, upgrade, downgrade, switch, choose.
     */
    public function comparedTo(?Membership $currentPlan): string
    {
        if (!$currentPlan) {
            return 'choose';
        }

        if ((int) $currentPlan->id === (int) $this->id) {
            return 'current';
        }

        $mine = $this->annualisedPrice();
        $theirs = $currentPlan->annualisedPrice();

        if ($mine > $theirs) {
            return 'upgrade';
        }

        if ($mine < $theirs) {
            return 'downgrade';
        }

        // Same yearly cost on a different plan — neither up nor down.
        return 'switch';
    }
}
