<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class PaginationController extends Controller
{
    public function set_pagination_per_page( $per_page = 20 ) {

        session( [ 'pagination_per_page' => $per_page ] );

        return Redirect::back();
    }
}
