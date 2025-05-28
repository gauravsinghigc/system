<?php if (DEVICE_TYPE != "MOBILE") { ?>
    <?php if (INTERNAL_CHAT_APP == "true") { ?>
        <a class="AppChatOptions">
            <i class="bi bi-chat-dots-fill"></i>
            <span class="badge bg-danger badge-number">4</span>
        </a>
    <?php } ?>
<?php } ?>
<?php if (DEVICE_TYPE == "COMPUTER") { ?>
    <footer id="footer" class="footer">
        <div class="copyright">
            <?php echo DATE("Y"); ?> &copy; Copyright <strong><span><?php echo APP_NAME; ?></span></strong>. All Rights Reserved
        </div>
    </footer>
<?php } ?>
<script>
    // Save scroll position before page unloads
    window.addEventListener('beforeunload', () => {
        const key = `scrollPosition_${window.location.pathname}`;
        localStorage.setItem(key, window.scrollY);
    });

    // Restore scroll position on page load
    document.addEventListener('DOMContentLoaded', () => {
        const key = `scrollPosition_${window.location.pathname}`;
        const scrollPosition = localStorage.getItem(key);
        if (scrollPosition) {
            window.scrollTo(0, parseInt(scrollPosition));
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        let activeTab = localStorage.getItem("activeTab");

        // अगर लोकल स्टोरेज में टैब सेव है, तो उसे एक्टिव करो
        if (activeTab) {
            let selectedTab = document.querySelector(`[data-bs-target="${activeTab}"]`);
            if (selectedTab) {
                // सभी टैब्स से `active` क्लास हटाएं
                document.querySelectorAll(".nav-link").forEach(tab => tab.classList.remove("active"));
                document.querySelectorAll(".tab-pane").forEach(tabPane => tabPane.classList.remove("show", "active"));

                // सेव किए गए टैब को एक्टिव करो
                selectedTab.classList.add("active");
                document.querySelector(activeTab).classList.add("show", "active");
            }
        }

        // सभी टैब्स पर क्लिक इवेंट ऐड करें ताकि नए टैब पर क्लिक होते ही लोकल स्टोरेज अपडेट हो जाए
        document.querySelectorAll(".nav-link").forEach(function(tab) {
            tab.addEventListener("click", function() {
                let target = this.getAttribute("data-bs-target");
                localStorage.setItem("activeTab", target);
            });
        });
    });
</script>