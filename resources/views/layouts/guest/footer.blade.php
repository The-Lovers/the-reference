<footer>
    <p>
        <span>
            <strong>{{ __('index.title') }}</strong>
            – {{ __('index.footer.privacy') }}
        </span>
        <a href="https://wa.me/237653476952">{{ __('index.footer.contact') }}</a>
        <span>
            Copyright &copy;
            <span id="year"></span>.
            {{ __('index.footer.rights') }}
        </span>
    </p>
</footer>
<script>
    document.getElementById("year").textContent = new Date().getFullYear();
</script>
