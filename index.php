<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vlog Planning Guide v2</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1 class="title-font gradient-text">Vlog Planning Guide</h1>
        <p class="subtitle">Your complete day-in-the-life content blueprint with timing, tips, and editing essentials</p>
        
        <div class="badges">
            <span class="badge">8 minutes total</span>
            <span class="badge">7 segments</span>
            <span class="badge">Professional editing</span>
        </div>

        <div class="action-buttons">
            <button class="btn btn-primary" id="downloadBtn">📥 Download Guide</button>
            <button class="btn btn-secondary" id="exportBtn">📊 Export as JSON</button>
        </div>
    </header>

    <div class="container"></div>

    <footer>
        <p>Ready to create your vlog? 🎥</p>
        <p>Follow this guide segment by segment and you'll have an engaging day-in-the-life video your viewers will love!</p>
    </footer>

    <script src="js/app.js"></script>
</body>

<div id="editModal" class="modal">
    <div class="modal-content glass-effect">
        <div class="modal-header title-font gradient-text">Edit Segment Details</div>
        <div class="modal-body">
            <input type="hidden" id="editSegmentId">
            
            <label style="font-weight:600; display:block; margin-bottom:5px; color:#333;">📹 Main Shots (Separate lines with | )</label>
            <textarea id="editMainShots" placeholder="Shot 1|Shot 2|Shot 3" style="width:100%; height:100px; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>

            <label style="font-weight:600; display:block; margin-bottom:5px; color:#333;">🎬 Visuals (Separate tags with | )</label>
            <textarea id="editVisuals" placeholder="Tag 1|Tag 2|Tag 3" style="width:100%; height:80px; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>

            <label style="font-weight:600; display:block; margin-bottom:5px; color:#333;">💡 Pro Tips (Separate tips with | )</label>
            <textarea id="editTips" placeholder="Tip 1|Tip 2" style="width:100%; height:80px; margin-bottom:20px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary" onclick="updateSegmentData()">Save Changes</button>
        </div>
    </div>
</div>
<<div id="createModal" class="modal">
    <div class="modal-content glass-effect">
        <div class="modal-header title-font gradient-text">Add New Vlog Segment</div>
        <div class="modal-body">
            <label style="font-weight:600; display:block; margin-bottom:5px;">Segment Name</label>
            <input type="text" id="newSegmentName" placeholder="e.g., Evening Routine" style="width:100%; padding:10px; margin-bottom:15px; border-radius:8px; border:1px solid #ddd;">

            <div style="display:flex; gap:10px; margin-bottom:15px;">
                <div style="flex:1;">
                    <label style="font-weight:600; display:block; margin-bottom:5px;">Start Time</label>
                    <input type="text" id="newStartTime" placeholder="6:30" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                </div>
                <div style="flex:1;">
                    <label style="font-weight:600; display:block; margin-bottom:5px;">End Time</label>
                    <input type="text" id="newEndTime" placeholder="8:00" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                </div>
            </div>

            <label style="font-weight:600; display:block; margin-bottom:5px;">Duration</label>
            <input type="text" id="newDuration" placeholder="1.5 minutes" style="width:100%; padding:10px; margin-bottom:15px; border-radius:8px; border:1px solid #ddd;">

            <label style="font-weight:600; display:block; margin-bottom:5px;">📹 Main Shots (Separate with | )</label>
            <textarea id="newMainShots" placeholder="Shot 1|Shot 2" style="width:100%; height:60px; padding:10px; margin-bottom:15px; border-radius:8px; border:1px solid #ddd;"></textarea>

            <label style="font-weight:600; display:block; margin-bottom:5px;">🎬 Visuals (Separate with | )</label>
            <textarea id="newVisuals" placeholder="Tag 1|Tag 2" style="width:100%; height:60px; padding:10px; margin-bottom:15px; border-radius:8px; border:1px solid #ddd;"></textarea>

            <label style="font-weight:600; display:block; margin-bottom:5px;">💡 Pro Tips (Separate with | )</label>
            <textarea id="newTips" placeholder="Tip 1|Tip 2" style="width:100%; height:60px; padding:10px; margin-bottom:15px; border-radius:8px; border:1px solid #ddd;"></textarea>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeCreateModal()">Cancel</button>
            <button class="btn btn-primary" onclick="saveNewSegment()">Add Segment</button>
        </div>
    </div>
</div>
</html>
