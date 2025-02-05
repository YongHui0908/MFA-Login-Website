document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.start-exam').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const examId = this.dataset.examId;
            const examName = this.dataset.examName;
            const link = this.dataset.link;
            const action = this.textContent.trim() === 'Open Exam' ? 'start' : 'complete';

            Swal.fire({
                title: action === 'start' ? 'Start Exam?' : 'Complete Exam?',
                text: action === 'start' ? 'You are about to start the exam.' : 'You are about to complete the exam.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'Cancel',
            }).then(result => {
                if (result.isConfirmed) {
                    fetch('../Online University Examination Website/handle_exam_action.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ examId, examName, action })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success!', data.message, 'success').then(() => {
                                    if (action === 'start') {
                                        window.open(link, '_blank');
                                    }
                                    location.reload(); // Refresh to update UI
                                });
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'Something went wrong: ' + error.message, 'error');
                        });
                }
            });
        });
    });
});
