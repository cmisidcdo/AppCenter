<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDetail extends Model
{
    use HasFactory;


    public function application()
    {
        return $this->hasOne(Application::class, "id", "application_id");
    }
}
