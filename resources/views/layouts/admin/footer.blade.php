<footer class="admin-footer">
    <div class="admin-footer__inner">
        <span>{{ __('dashboard.footer.caption', ['app' => __('index.title')]) }}</span>
        <span>{{ __('dashboard.footer.rights', ['year' => now()->year]) }}</span>
    </div>
</footer>

<style>
    .admin-footer {
        margin-top: 1.5rem;
        padding: 1rem 0 0;
    }

    .admin-footer__inner {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: .75rem 1.25rem;
        padding: 1rem 1.25rem;
        border-top: 1px solid rgba(15, 35, 52, .08);
        color: #6b7280;
        font-size: .92rem;
    }

    @media (max-width: 768px) {
        .admin-footer__inner {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
