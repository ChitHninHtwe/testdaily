let segments = [];

// 1. Initialize application when DOM structure is ready
document.addEventListener('DOMContentLoaded', () => {
    loadSegments();
    setupGlobalEventListeners();
});

// Crash-proof event listener attachment
function setupGlobalEventListeners() {
    const downloadBtn = document.getElementById('downloadBtn');
    const exportBtn = document.getElementById('exportBtn');
    const closeModalBtn = document.getElementById('closeModal');

    if (downloadBtn) downloadBtn.addEventListener('click', downloadGuide);
    if (exportBtn) exportBtn.addEventListener('click', exportAsJSON);
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
}

// Fetch segments dynamically from the database
function loadSegments() {
    fetch('api/get_segments.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                segments = data.segments;
                renderSegments();
            } else {
                console.error('API error:', data.message);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Render segment cards dynamically into the container
function renderSegments() {
    const container = document.querySelector('.container');
    container.innerHTML = '';

    segments.forEach(segment => {
        // Convert pipe-separated strings into readable arrays
        const mainShotsArray = segment.main_shots ? segment.main_shots.split('|') : [];
        const visualsArray = segment.visuals ? segment.visuals.split('|') : [];
        const tipsArray = segment.tips ? segment.tips.split('|') : [];

        const card = document.createElement('div');
        card.className = 'segment-card';
        
        // Toggle expansion cleanly on click
        card.addEventListener('click', (e) => {
            if (!e.target.closest('button')) {
                toggleSegment(card);
            }
        });

        card.innerHTML = `
            <div class="segment-header">
                <div class="segment-info">
                    <h2>${segment.segment_name}</h2>
                    <p class="segment-time">${segment.start_time} – ${segment.end_time} 
                        <span style="color: #ec4899;">${segment.duration}</span>
                    </p>
                </div>
                <span class="expand-icon">▼</span>
            </div>

            <div class="segment-details">
                ${mainShotsArray.length > 0 && mainShotsArray[0] !== "" ? `
                    <div class="detail-section">
                        <h3>📹 Main Shots:</h3>
                        <ul>
                            ${mainShotsArray.map(shot => `<li>${shot}</li>`).join('')}
                        </ul>
                    </div>
                ` : '<p style="color:#999; font-style:italic; margin-bottom:10px;">No main shots added yet.</p>'}

                ${visualsArray.length > 0 && visualsArray[0] !== "" ? `
                    <div class="detail-section">
                        <h3>🎬 Visuals:</h3>
                        <div class="tag-group">
                            ${visualsArray.map(visual => `<span class="tag">${visual}</span>`).join('')}
                        </div>
                    </div>
                ` : ''}

                ${tipsArray.length > 0 && tipsArray[0] !== "" ? `
                    <div class="detail-section">
                        <div class="tip-box">
                            💡 <strong>Pro Tips:</strong><br>
                            ${tipsArray.map(tip => `• ${tip}`).join('<br>')}
                        </div>
                    </div>
                ` : ''}

                <div style="margin-top: 20px; display: flex; gap: 10px;">
                    <button class="btn btn-primary" onclick="event.stopPropagation(); editSegment(${segment.id})">Edit</button>
                    <button class="btn btn-secondary" onclick="event.stopPropagation(); deleteSegment(${segment.id})">Delete</button>
                </div>
            </div>
        `;
        container.appendChild(card);
    });
}

function toggleSegment(card) {
    document.querySelectorAll('.segment-card.expanded').forEach(c => {
        if (c !== card) {
            c.classList.remove('expanded');
        }
    });
    card.classList.toggle('expanded');
}

// ==========================================
// CREATE (INSERT) FUNCTIONALITY
// ==========================================
function openCreateModal() {
    document.getElementById('createModal').classList.add('active');
}

function closeCreateModal() {
    document.getElementById('createModal').classList.remove('active');
    document.getElementById('newSegmentName').value = '';
    document.getElementById('newStartTime').value = '';
    document.getElementById('newEndTime').value = '';
    document.getElementById('newDuration').value = '';
    document.getElementById('newMainShots').value = '';
    document.getElementById('newVisuals').value = '';
    document.getElementById('newTips').value = '';
}

function saveNewSegment() {
    const payload = {
        segment_name: document.getElementById('newSegmentName').value,
        start_time: document.getElementById('newStartTime').value,
        end_time: document.getElementById('newEndTime').value,
        duration: document.getElementById('newDuration').value,
        main_shots: document.getElementById('newMainShots').value,
        visuals: document.getElementById('newVisuals').value,
        tips: document.getElementById('newTips').value
    };

    fetch('api/create_segment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('New segment created seamlessly! 🚀');
            closeCreateModal();
            loadSegments();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error creating segment:', error));
}

// ==========================================
// UPDATE (EDIT) FUNCTIONALITY 
// ==========================================
function editSegment(id) {
    const segment = segments.find(s => s.id == id);
    if (!segment) {
        console.error("Could not find segment array matching ID:", id);
        return;
    }

    // Populate data inputs fields inside edit modal layout
    document.getElementById('editSegmentId').value = segment.id;
    document.getElementById('editMainShots').value = segment.main_shots || '';
    document.getElementById('editVisuals').value = segment.visuals || '';
    document.getElementById('editTips').value = segment.tips || '';

    document.getElementById('editModal').classList.add('active');
}

function closeModal() {
    document.getElementById('editModal').classList.remove('active');
}

function updateSegmentData() {
    const payload = {
        id: document.getElementById('editSegmentId').value,
        main_shots: document.getElementById('editMainShots').value,
        visuals: document.getElementById('editVisuals').value,
        tips: document.getElementById('editTips').value
    };

    fetch('api/save_segment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Segment updated successfully! ✨');
            closeModal();
            loadSegments();
        } else {
            alert('Update failed: ' + data.message);
        }
    })
    .catch(error => console.error('Error updating segment:', error));
}

// ==========================================
// DELETE FUNCTIONALITY
// ==========================================
function deleteSegment(id) {
    if (confirm('Are you sure you want to delete this segment?')) {
        fetch('api/delete_segment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Segment deleted successfully! 🗑️');
                loadSegments();
            }
        });
    }
}

// Utilities
function downloadGuide() { /* ... unchanged ... */ }
function exportAsJSON() { /* ... unchanged ... */ }

function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}