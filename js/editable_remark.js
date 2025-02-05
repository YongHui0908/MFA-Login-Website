document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.editable-remark').forEach(input => {
        input.addEventListener('change', function () {
            const examId = this.dataset.id;
            const newRemark = this.value;
            
            fetch('../Online University Examination Website/update_remark.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: examId, remark: newRemark })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Remark updated successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error updating remark: ' + data.message,
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                    
                    // alert('Error updating remark: ' + data.message);
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Something went wrong: ' + error.message, 'error');
            });
        });
    });
});
