<form method="post" id="" action="{{ route('feedback') }}" class="feedback_form">
    {{--TODO--}}
    <div class="contacts__field contacts__field_firstName">
        <input id="firstName" name="first_name" class="contacts__input" type="text" placeholder="First name">
    </div>
    <div class="contacts__field contacts__field_lastName">
        <input id="lastName" name="last_name" class="contacts__input" type="text" placeholder="Lastname">
    </div>
    <div class="contacts__field contacts__field_phone">
        <input id="phone" name="phone" class="contacts__input" type="text" placeholder="Phone">
    </div>
    <div class="contacts__field contacts__field_email">
        <input id="email" name="email" class="contacts__input" type="text" placeholder="E-Mail">
    </div>
    <div class="contacts__field contacts__field_date">
        <input id="date" name="date_time" class="contacts__input" type="text" placeholder="Date">
    </div>
    <div class="contacts__field contacts__field_num">
        <input id="num" name="people_amount" class="contacts__input" type="text" placeholder="Number of persons">
    </div>
    <div class="contacts__field contacts__field_text">
        <textarea class="contacts__textarea" name="description" id="text" cols="30" rows="4"  placeholder="Enter Your Request"></textarea>
    </div>

    <div class="contacts__submit">
        <input class="contacts__submit-btn" type="submit" value="Send">
    </div>
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
</form>
<span class="response-message" style="display: none;"></span>