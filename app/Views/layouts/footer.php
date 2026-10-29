<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-brand">
            <span>© <?= date('Y') ?> Permata Bangsa School</span>
        </div>

        <div class="footer-info">
            Student Management System
        </div>
    </div>
</footer>

<style>
    .site-footer {
        margin-top: 50px;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        padding: 20px 40px;
    }

    .footer-content {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .footer-brand {
        font-size: 14px;
        color: #64748b;
    }

    .footer-info {
        font-size: 14px;
        color: #94a3b8;
    }

    @media (max-width: 600px) {
        .site-footer {
            padding: 18px 20px;
        }

        .footer-content {
            flex-direction: column;
            text-align: center;
            gap: 8px;
        }
    }
</style>