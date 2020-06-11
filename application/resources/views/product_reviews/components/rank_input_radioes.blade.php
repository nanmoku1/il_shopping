@for($i = 1; $i <= 5; $i++)
    @component('product_reviews.components.rank_input_radio', ['rank_number' => $i, 'is_rank_checked' => ($i == 1 || $rank == $i)])
    @endcomponent
@endfor
