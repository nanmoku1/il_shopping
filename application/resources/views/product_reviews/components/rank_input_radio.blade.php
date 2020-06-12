<div class="form-check form-check-inline">
    <input type="radio" class="form-check-input" id="rank{{ $rank_number }}" name="rank" value="{{ $rank_number }}" {{ $is_rank_checked ? "checked" : "" }}>
    <label class="form-check-label" for="rank{{ $rank_number }}">星{{ $rank_number }}つ</label>
</div>
