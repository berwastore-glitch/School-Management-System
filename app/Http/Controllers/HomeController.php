<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() { return view('frontend.home'); }
    public function features() { return view('frontend.features'); }
    public function about() { return view('frontend.about'); }
    public function pricing() { return view('frontend.pricing'); }
    public function contact() { return view('frontend.contact'); }
}
