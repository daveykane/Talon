{# app/views/session/signup.volt #}

{%  block content %}
    {{  content() }}
{% endblock %}

{%  block flash %}
    {{ flashSession.output() }}
{% endblock %}

{{ form('method': 'post') }}

    {{ form.label('name') }}
    {{ form.render('name') }}
    {{ form.messages('name') }}

    {{ form.label('email') }}
    {{ form.render('email') }}
    {{ form.messages('email') }}

    {{ form.label('confirmEmail') }}
    {{ form.render('confirmEmail') }}
    {{ form.messages('confirmEmail') }}

    {{ form.label('password') }}
    {{ form.render('password') }}
    {{ form.messages('password') }}

    {{ form.label('confirmPassword') }}
    {{ form.render('confirmPassword') }}
    {{ form.messages('confirmPassword') }}

    {#{{ form.render('terms') }}#}
    {#{{ form.label('terms') }}#}
    {#{{ form.messages('terms') }}#}

    {{ form.render('Sign Up') }}

    {{ form.render('csrf', ['value': security.getToken()]) }}
    {{ form.messages('csrf') }}

{{ end_form() }}