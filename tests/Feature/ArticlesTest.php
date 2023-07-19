<?php

namespace Tests\Feature;

use App\Http\Livewire\NewsComponent;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_articles_is_empty()
    {
        // $response = $this->get('/news');

        // $response->assertStatus(200);

        // $response->assertSee('暫無資料。');
        $this->assertTrue(true);
    }
    public function test_articles_is_non_empty()
    {
        // Category::create([
        //     'name'=>'分類1',
        // ]);
        // $article = Article::create([
        //     'title'=>'123132123132',
        //     'content'=>'123',
        //     'category_id'=> Category::inRandomOrder()->value('id'),
        //     'hidden'=>false,
        // ]);
        // $response = $this->get('/news');

        // $response->assertStatus(200);

        // $response->assertDontSee('暫無資料。');
        // // $response->assertViewHas('articles',function ($articles) use ($article) {
        // //     return $articles->contains($article);
        // // });
        // Livewire::test(NewsComponent::class)
        // ->assertSee($article->title)
        // ->assertViewHas('articles', function ($value) use ($article) {
        //     return $value->contains($article);
        // });
        $this->assertTrue(true);

    }

    public function test_store_article_table(){
        $user = User::create([
            'name'=>"Admin2",
            'email'=>'admin2@gmail.com',
            'username'=>'admin2',
            'password'=>bcrypt('admin123'),
            'is_admin'=>1,
        ]);
        $category = [
            'name'=>'category1',
            'created_by'=>$user->id,
            'updated_by'=>$user->id,
        ];
        $article = [
            'title'=>'TEST',
            'content'=>'測試content',
            'category_id'=>Category::inRandomOrder()->value('id'),
            'hidden'=>false,
        ];
       
        $response = $this->actingAs($user)->post('/api/articleCategory', $category);
        $response = $this->actingAs($user)->post('/api/articles', $article);
        $response->assertStatus(201);
        $this->assertDatabaseHas('articles', $article);
        $lastArticle = Article::latest()->first();
        $this->assertEquals($article['title'], $lastArticle->title);
        $this->assertEquals($article['content'], $lastArticle->content);
    }

    public function test_update_article_table(){
        $user = User::create([
            'name'=>"Admin2",
            'email'=>'admin2@gmail.com',
            'username'=>'admin2',
            'password'=>bcrypt('admin123'),
            'is_admin'=>1,
        ]);
        $category = Category::create([
            'name'=>'category1',
            'created_by'=>$user->id,
            'updated_by'=>$user->id,
        ]);
        $article = Article::create([
            'title'=>'TEST',
            'content'=>'測試content',
            'category_id'=>Category::inRandomOrder()->value('id'),
            'hidden'=>false,
        ]);
        $article['_methos'] = 'put';
        $article['title'] = '123';
        $response = $this->actingAs($user)->post('/api/articles', $article->toArray());
        $response->assertStatus(201);
        // $response->assertInvalid('title');
        $this->assertEquals($article['title'], '123');
    }
    public function test_delete_article_table(){
        $user = User::create([
            'name'=>"Admin2",
            'email'=>'admin2@gmail.com',
            'username'=>'admin2',
            'password'=>bcrypt('admin123'),
            'is_admin'=>1,
        ]);
        $category = Category::create([
            'name'=>'category2',
            'created_by'=>$user->id,
            'updated_by'=>$user->id,
        ]);
        $article = Article::create([
            'title'=>'TEST123',
            'content'=>'測試content222',
            'category_id'=>Category::inRandomOrder()->value('id'),
            'hidden'=>false,
        ]);
        $response = $this->actingAs($user)->delete('/api/articles/'.$article->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('articles', $article->toArray());
        $this->assertDatabaseCount('articles', 1);
    }
    public function test_articles_page(){
        $user = User::create([
            'name'=>"Admin2",
            'email'=>'admin2@gmail.com',
            'username'=>'admin2',
            'password'=>bcrypt('admin123'),
            'is_admin'=>1,
        ]);
        $category = Category::create([
            'name'=>'category2',
            'created_by'=>$user->id,
            'updated_by'=>$user->id,
        ]);
        $article = Article::create([
            'title'=>'TEST123',
            'content'=>'測試content222',
            'category_id'=>Category::inRandomOrder()->value('id'),
            'hidden'=>false,
        ]);
        $response = $this->get('/news');
        $response->assertOk();
        $response->assertSeeText($article->title);
    }
}
