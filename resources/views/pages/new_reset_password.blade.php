@extends('layouts.app')
@section('title')
Mot de passe oublie :: Mycartraders
@endsection
@section('content')
<!--=============== LOGIN ===============-->
<section class="newsletter section">
    <div class="newsletter__container container">
        <h2 class="section__title">Reinitialisation de mot de passe</h2>
        <p class="newsletter__description">
            Entrer votre adresse mail pour qu'on retrouve votre compte.
        </p>

        <form action="{{ route('reinitialiser.password-reset', $reset_code) }}" method="post" id="reinitialiser-password-reset" class="login__form grid">
            @csrf
            <div class="login__content">
                <label for="email_user" class="login__label">Email</label>
                <input type="email" name="email_user" class="login__input">
            </div>

            <div class="login__content">
                <label for="password" class="login__label">Nouveau mot de passe</label>
                <input type="password" name="password" class="login__input">
            </div>

            <div class="login__content">
                <label for="password_confirmation" class="login__label">Retaper le mot de passe</label>
                <input type="password" name="password_confirmation" class="login__input">
            </div>

            <div>
                <button type="submit" class="button" style="margin-right: 25px;">Envoyer</button>
            </div>

            <div class="signup">Avez-vous un compte? <a href="{{ route('inscription.view') }}">Creer un compte</a></div>
        </form>
    </div>
</section>
@endsection