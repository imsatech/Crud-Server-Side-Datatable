var tabs = $('.table').DataTable({
    "order": [[0, "desc"]],
    "processing": true,
    "serverSide": true,
    "ajax": "<?php echo base_url('AccountMaster/GetData'); ?>"
});
