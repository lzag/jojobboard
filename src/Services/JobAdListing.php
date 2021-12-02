<?php

namespace App\Services;

use App\Models\JobAd;
use App\Models\Company;
use App\Services\Service;

class JobAdListing extends Service
{
    public const FIELDS = [
        JobAd::class => ['title', 'id', 'description', 'salary_min', 'salary_max', 'location', 'time_posted'],
        Company::class => ['name'],
    ];
}
