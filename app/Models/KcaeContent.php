<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\KcaeContent
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $mid-section
 * @property string|null $last-section-top
 * @property string|null $last-section-box1
 * @property string|null $last-section-box2
 * @property string|null $last-section-box3
 * @property string|null $last-section-bottom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereLastSectionBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereLastSectionBox1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereLastSectionBox2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereLastSectionBox3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereLastSectionTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereMidSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $hero_slider_title
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeContent whereHeroSliderTitle($value)
 */
class KcaeContent extends Model
{
    protected $guarded = [];
}
