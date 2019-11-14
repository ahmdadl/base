<?php

declare(strict_types=1);

namespace App\Controllers;

trait HomeModelDataTrait
{
    public function getData(): array
    {
        $pros = [
            $this->createPros(
                'Responsive', 
                'desktop',
                'some thing to be said about that'
            ),
            $this->createPros(
                'Responsive', 
                'desktop',
                'some thing to be said about that'
            ),
            $this->createPros(
                'Responsive', 
                'desktop',
                'some thing to be said about that'
            ),
            $this->createPros(
                'Responsive', 
                'desktop',
                'some thing to be said about that'
            ),
            $this->createPros(
                'Responsive', 
                'desktop',
                'some thing to be said about that'
            ),
            $this->createPros(
                'Responsive', 
                'desktop',
                'some thing to be said about that'
            ),
        ];

        $projects = [
            $this->createProject(
                'MyBlog',
                'MySelf',
                'an laravel blog to show what i can do as an project',
                ['laravel', 'vueJs', 'MySql', 'typeScript', 'bootstrap 4']
            ),
            $this->createProject(
                'MyBlog',
                'MySelf',
                'an laravel blog to show what i can do as an project',
                ['laravel', 'vueJs', 'MySql', 'typeScript', 'bootstrap 4']
            ),
            $this->createProject(
                'MyBlog',
                'MySelf',
                'an laravel blog to show what i can do as an project',
                ['php', 'oop', 'vueJs', 'MySql', 'typeScript', 'bootstrap 4']
            ),
            $this->createProject(
                'MyBlog',
                'MySelf',
                'an laravel blog to show what i can do as an project',
                ['php', 'oop', 'jquery', 'MySql', 'typeScript', 'bootstrap 4']
            ),
            $this->createProject(
                'MyBlog',
                'MySelf',
                'an laravel blog to show what i can do as an project',
                ['laravel', 'es5', 'MySql', 'typeScript', 'bootstrap 4']
            ),
            $this->createProject(
                'MyBlog',
                'MySelf',
                'an laravel blog to show what i can do as an project',
                ['lumen', 'vueJs', 'MySql', 'typeScript', 'bootstrap 4']
            ),
        ];



        return [$pros, $projects];
    }


    private function createPros(
        string $title,
        string $icon,
        string $txt
    ): object {
        return (object) [
            'title' => $title,
            'icon' => $icon,
            'txt' => $txt
        ];
    }

    private function createProject(
        string $title,
        string $client,
        string $info,
        array $tags
    ) : object {
        return (object) [
            'title' => $title,
            'client' => $client,
            'info' => $info,
            'tags' => $tags
        ];
    }
}
