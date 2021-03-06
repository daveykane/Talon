{# app/views/users/new.volt #}

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

    {{ form.label('password') }}
    {{ form.render('password') }}
    {{ form.messages('password') }}

    {{ form.render('Save') }}

    {{ form.render('csrf', ['value': security.getToken()]) }}
    {{ form.messages('csrf') }}

{{ end_form() }}