<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = ['company_name'];

    public function products() {
        return $this->hasMany(Product::class, 'company_id', 'id');
    }

    public function getCompanyId() {
        $companies = DB::table('companies')->get()->toArray();

        return $companies;
    }
}
