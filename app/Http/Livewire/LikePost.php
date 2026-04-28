<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class LikePost extends Component
{
    public Post $post;
    public bool $isLiked;
    public $likes;

    public function mount(Post $post)
    {
        $this->isLiked = auth()->check() ? $post->checkLike(auth()->user()) : false;
        $this->likes = $post->likes()->count();
    }

    public function like()
    {
        if (!auth()->check()) return;
        /** Sin el if (!auth()->check()) return; en like(), alguien podría llamar la acción Livewire directamente aunque no esté autenticado. */

        if ($this->post->user_id === auth()->user()->id) return;

        if ($this->post->checkLike(auth()->user())) {
            $this->post->likes()->where('user_id', auth()->user()->id)->delete();
            $this->isLiked = false;
        } else {
            $this->post->likes()->create(['user_id' => auth()->user()->id]);
            $this->isLiked = true;
        }

        $this->likes = $this->post->likes()->count();
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
