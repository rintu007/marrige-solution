<div class="box-body" style="background: #ddd; min-height: 400px;">
 
            @foreach($users as $user)
 
                @include('user.includes.cards.userCard')
 
            @endforeach
 
 

        

    </div>
    <div class="box-footer my-search-term-user-links">
        {{ $users->appends(['marital_status' => $marital_status])->links()}}
    </div>