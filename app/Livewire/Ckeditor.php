<?php

namespace App\Livewire;

use Livewire\Component;

class Ckeditor extends Component
{
    public $content;
    public $message;
    public $description;
    public $editor;
    public $editedTaskContent;

    public function render()
    {
        return view('livewire.ckeditor')
            ->layout('layouts.ckeditor');;
    }
}
