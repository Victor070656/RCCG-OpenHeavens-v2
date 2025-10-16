        <!-- Footer Start -->
        <footer class="d-footer">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <p class="mb-0">© <?php echo date('Y'); ?> RCCG Open Heavens Parish. All Rights Reserved.</p>
                </div>
                <div class="col-auto">
                    <p class="mb-0">Made with <i class="ph ph-heart-straight text-danger-600"></i> for the Kingdom</p>
                </div>
            </div>
        </footer>
        <!-- Footer End -->
    </div>
</div>

<!-- jQuery -->
<script src="assets/js/jquery-3.7.1.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="assets/js/boostrap.bundle.min.js"></script>

<!-- Phosphor Icons -->
<script src="assets/js/phosphor-icon.js"></script>

<!-- DataTables (Optional - only if included in header) -->
<?php if (isset($include_datatables) && $include_datatables === true): ?>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script>
    // Initialize DataTables
    if (jQuery.fn.DataTable) {
        $('.data-table').DataTable({
            pageLength: 10,
            ordering: true,
            searching: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            }
        });
    }
</script>
<?php endif; ?>

<!-- File Upload (Optional - only if included in header) -->
<?php if (isset($include_file_upload) && $include_file_upload === true): ?>
<script src="assets/js/file-upload.js"></script>
<?php endif; ?>

<!-- Editor Quill (Optional - only if included in header) -->
<?php if (isset($include_editor) && $include_editor === true): ?>
<script src="assets/js/editor-quill.js"></script>
<script>
    // Initialize Quill Editor
    if (typeof Quill !== 'undefined') {
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write something...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });
    }
</script>
<?php endif; ?>

<!-- Calendar (Optional - only if included in header) -->
<?php if (isset($include_calendar) && $include_calendar === true): ?>
<script src="assets/js/full-calendar.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script src="assets/js/calendar.js"></script>
<?php endif; ?>

<!-- Apex Charts (Optional - only if included in header) -->
<?php if (isset($include_charts) && $include_charts === true): ?>
<script src="assets/js/apexcharts.min.js"></script>
<?php endif; ?>

<!-- Main JS -->
<script src="assets/js/main.js"></script>

<!-- Custom Scripts (Optional - for page-specific JavaScript) -->
<?php if (isset($custom_js)): ?>
<script>
    <?php echo $custom_js; ?>
</script>
<?php endif; ?>

<!-- Sweet Alert for confirmations -->
<script>
    // Delete confirmation
    function confirmDelete(message = 'Are you sure you want to delete this item?') {
        return confirm(message);
    }

    // Success message auto-hide
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>

</body>
</html>
