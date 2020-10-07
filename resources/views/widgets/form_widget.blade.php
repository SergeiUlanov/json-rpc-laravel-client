<div class="wg_form">

    <h2>Demo FormWidget</h2>

    <form method="POST" action="#">
        @csrf
        <label for="user_name" class="wg_label">Введите имя</label>
        <input name="user_name" class="wg_input @error('user_name') is-invalid @enderror"
               id="user_name" type="text" placeholder="Введите имя"
               value="{{ old('user_name') ?? (isset($config['error']) ? $config['user_name'] : '')  }}">

        <label for="user_text" class="wg_label">Введите текст</label>
        <textarea name="user_text" placeholder="Введите текст" class="wg_text @error('user_text') is-invalid @enderror"
                  id="user_text" >{{ old('user_text') ?? (isset($config['error']) ? $config['user_text'] : '') }}</textarea>

        <input name="page_uid" type="hidden" value="{{ $config['page_uid'] }}">

        @if($errors->any())
            <ul class="wg_input-errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @isset($config['result']['ok'])
            <div class="wg_resp-ok">{{ $config['result']['ok'] }}</div>
        @endisset

        @isset($config['error']['message'])
            <div class="wg_resp-err">{{ $config['error']['message'] }}</div>
        @endisset

        <div class="wd_ctrl">
            <button type="submit" class="wg_submit">Отправить</button>
        </div>
    </form>

    <!-- <div class="wg_info">Page uid: {{ $config['page_uid'] }}</div> -->

    @isset($config['page_recs']['error']['message'])
        <div class="wg_rear-err">{{ $config['page_recs']['error']['message'] }}</div>
    @endisset

    @isset($config['page_recs']['result'])
        @foreach ($config['page_recs']['result'] as $pageRec)
            <div class="wg_rec">
                <span class="wg_name">{{ $pageRec['name'] }}</span>: {{ $pageRec['text'] }}
                <div class="wg_time">{{ $pageRec['time'] }}</div>
            </div>
        @endforeach
    @endisset

    @isset($config['server_data']['error']['message'])
        <p class="wg_data-err">Ошибка получения данных с удалённого сервера: {{ $config['server_data']['error']['message'] }}</p>
    @endisset

</div>
