<?php

namespace JoeDixon\Translation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use JoeDixon\Translation\Drivers\Translation;
use JoeDixon\Translation\Http\Requests\LanguageRequest;

class LanguageController extends Controller
{
    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function index(Request $request)
    {
        $languages = $this->translation->allLanguageswithDirections();

        return view('translation::languages.index', compact('languages'));
    }

    public function create()
    {
        $directions  = ['ltr' => 'Left To Right', 'rtl' => 'Right To Left'];
        return view('translation::languages.create', compact('directions'));
    }

    public function store(LanguageRequest $request)
    {
        $this->translation->addLanguage($request->locale, $request->name, $request->direction);

        return redirect()
            ->route('languages.index')
            ->with('success', __('translation::translation.language_added'));
    }
}
