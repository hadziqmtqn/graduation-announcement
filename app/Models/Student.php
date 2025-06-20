<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Student extends Model
{
    use HasSlug;

    protected $fillable = [
        'username',
        'full_name',
        'school_year_id',
        'exam_number',
    ];

    public function getSlugOptions(): SlugOptions
    {
        // TODO: Implement getSlugOptions() method.
        return SlugOptions::create()
            ->generateSlugsFrom('full_name')
            ->saveSlugsTo('username');
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (Student $student) {
            $student->full_name = strtoupper($student->full_name);
            $student->school_year_id = SchoolYear::active()->first()->id;
        });

        static::updating(function (Student $student) {
            $student->full_name = strtoupper($student->full_name);
        });
    }

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function testScore(): HasOne
    {
        return $this->hasOne(TestScore::class, 'student_id');
    }

    // TODO Scope
    #[Scope]
    protected function search(Builder $query, $request): Builder
    {
        $search = $request['search'] ?? null;
        $schoolYearId = $request['school_year_id'] ?? null;

        return $query->when($search, fn($query) => $query->whereLike('full_name', 'like', '%' . $search . '%'))
            ->where('school_year_id', $schoolYearId);
    }

    #[Scope]
    protected function filterByExamNumber(Builder $query, $examNumber): Builder
    {
        return $query->where('exam_number', $examNumber);
    }
}
