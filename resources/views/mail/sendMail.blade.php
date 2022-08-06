<h2>Поступил вопрос:</h2>
<p>Из обратной связи на странице <a href="{{ Request::root() }}/about">О нас</a> с сайта {{ Request::root() }}</p>
<p>Содержание:</p>
<p>Имя: <span>{{ $name }}</span></p>
<p>Email: <span>{{ $email }}</span></p>
<p>Вопрос:</p>
<p>{{ $question }}</p>
