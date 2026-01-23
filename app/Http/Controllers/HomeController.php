<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'universities' => [
                ['id'=>1,'name'=>'جامعة صنعاء','rating'=>4.6,'logo'=>null],
                ['id'=>2,'name'=>'جامعة تعز','rating'=>4.3,'logo'=>null],
            ],
            'colleges' => [
                ['id'=>1,'name'=>'كلية الطب','university'=>'جامعة صنعاء'],
                ['id'=>2,'name'=>'كلية الهندسة','university'=>'جامعة تعز'],
            ],
            'majors' => [
                ['id'=>1,'name'=>'طب بشري','min_gpa'=>85],
                ['id'=>2,'name'=>'هندسة مدنية','min_gpa'=>80],
            ],
        ]);
    }
    
    public function show($id)
{
    return Inertia::render('show', [
        'university' => [
            'id' => $id,
            'name' => 'جامعة صنعاء',
            'description' => 'أقدم جامعة حكومية في اليمن.',
            'rating' => 4.6,
            'ratings_count' => 1200,
            'colleges' => [
                [
                    'id'=>1,
                    'name'=>'كلية الطب',
                    'majors'=>[
                        ['id'=>1,'name'=>'طب بشري'],
                        ['id'=>2,'name'=>'صيدلة'],
                    ]
                ]
            ]
        ]
    ]);
}

}
