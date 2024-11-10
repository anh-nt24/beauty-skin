<script>
    document.title = "Customer Service - FAQ";
</script>

<div class="container mt-5">
    <h3 class="mb-4">FAQ Management</h3>

    <!-- search -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <div class="flex-grow-1">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-chat"></i>
                                </span>
                                <input type="text" class="form-control" 
                                        placeholder="Enter key words..." 
                                        name="keyword">
                            </div>
                        </div>
                        <button id="searchFaQButton" type="button" class="btn btn-primary">Search</button>
                        <button id="resetFaQButton" class="btn btn-outline-secondary">Clear</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- total and add button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="bg-light rounded px-3 py-2">
            <span class="text-muted">Total FAQs:</span>
            <span class="fw-bold ms-2"><?php echo count($faqs); ?></span>
        </div>

        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg me-2"></i>
            Add New FaQ
        </button>
    </div>
    
    <!-- faq table list -->
    <div class="card">
        <div class="card-body">
            <table class="table" id="faqTableData">
                <thead>
                    <tr>
                        <th class="col-5">Question</th>
                        <th class="col-5">Answer</th>
                        <th class="col-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td><?= htmlspecialchars($faq['question']) ?></td>
                        <td><?= htmlspecialchars($faq['answer']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn" 
                                    data-id="<?= $faq['id'] ?>"
                                    data-question="<?= htmlspecialchars($faq['question']) ?>"
                                    data-answer="<?= htmlspecialchars($faq['answer']) ?>">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn" 
                                    onclick="deleteFaQ(<?php echo $faq['id']; ?>)">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal to edit faq -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="post">
                        <input type="hidden" id="editId">
                        <div class="mb-3">
                            <label for="editQuestion" class="form-label">Question</label>
                            <input type="text" class="form-control" name="question" id="editQuestion" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAnswer" class="form-label">Answer</label>
                            <textarea class="form-control" id="editAnswer" name="answer" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveChanges">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal to add faq -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" method="post" action="<?php echo ROOT_URL?>/admin/customer-service/faq/add">
                        <div class="mb-3">
                            <label for="addQuestion" class="form-label">Question</label>
                            <input type="text" class="form-control" id="addQuestion" name="question" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAnswer" class="form-label">Answer</label>
                            <textarea class="form-control" id="addAnswer" name="answer" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const searchInput = document.querySelector('input[name="keyword"]');
    const faqTableData = document.getElementById('faqTableData');

    searchInput.addEventListener('input', function() {
        filterFaQTable(this.value.trim());
    });

    function filterFaQTable(data) {
        const tableRows = faqTableData.getElementsByTagName('tr');

        for (let i = 1; i < tableRows.length; i++) {
            const row = tableRows[i];
            const questionCol = row.getElementsByTagName('td')[0];
            const answerCol = row.getElementsByTagName('td')[0];
            if (questionCol || answerCol) {
                const rowQuestion = questionCol.textContent.trim();
                const rowAnswer = answerCol.textContent.trim();
                if (rowQuestion.includes(data) || rowAnswer.includes(data)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
    }
</script>

<script>
    // init modal
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    let currentId = null;

    // edit button click handler
    $('.edit-btn').click(function() {
        currentId = $(this).data('id');
        $('#editId').val(currentId);
        $('#editQuestion').val($(this).data('question'));
        $('#editAnswer').val($(this).data('answer'));
        document.getElementById('editForm').setAttribute('action', `<?php echo ROOT_URL?>/admin/customer-service/faq/edit?id=${currentId}`)
        editModal.show();
    });

    // delete faq
    function deleteFaQ(id) {
        if (confirm('Are you sure you want to delete this FaQ?')) {
            fetch(`<?php echo ROOT_URL;?>/admin/customer-service/faq/delete?id=${id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert("Error deleting this FaQ.");
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                alert("An error occurred while processing your request.");
            });
        }
    }
</script>