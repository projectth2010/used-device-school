<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ปฏิทินการใช้อุปกรเสริมการเรียนการสอน 2024</title>
    <!-- Include Bootstrap, jQuery, and FullCalendar -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
</head>
<body>

<div class="container mt-4">
    <h2>ปฏิทินการใช้อุปกรเสริมการเรียนการสอน 2024</h2>
    <div id="calendar"></div>
</div>

<!-- Modal for Add/Edit Event -->
<!-- Modal for Add/Edit Event -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventModalLabel">รายละเอียดกิจกรรม</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="eventForm">
          <input type="hidden" id="eventId">
          <div class="form-group">
            <label for="eventTitle">ชื่อกิจกรรม</label>
            <input type="text" class="form-control" id="eventTitle" required>
          </div>
          <div class="form-group">
            <label for="eventSubTitle">ชื่อย่อยของกิจกรรม</label>
            <input type="text" class="form-control" id="eventSubTitle">
          </div>
          <div class="form-group">
            <label for="taName">ชื่อผู้สอน</label>
            <input type="text" class="form-control" id="taName">
          </div>
          <div class="form-group">
            <label for="schoolName">ชื่อโรงเรียน</label>
            <input type="text" class="form-control" id="schoolName">
          </div>

          <!-- ฟิลด์สำหรับเลือกโรงเรียน -->
          <div class="form-group">
              <label for="schoolSelect">โรงเรียน</label>
              <select class="form-control" id="schoolSelect" required>
                  <!-- ดึงข้อมูลโรงเรียนจากฐานข้อมูล -->
                  <?php
                  $result = mysqli_query($conn, "SELECT id, school_name FROM schools");
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='" . $row['id'] . "'>" . $row['school_name'] . "</option>";
                  }
                  ?>
              </select>
          </div>

          <!-- ฟิลด์สำหรับเลือกห้องเรียน -->
          <div class="form-group">
              <label for="classRoomSelect">ห้องเรียน</label>
              <select class="form-control" id="classRoomSelect" required>
                  <!-- ห้องเรียนจะถูกกรองตามโรงเรียนที่เลือก -->
              </select>
          </div>

          <div class="form-group">
            <label for="eventNote">หมายเหตุ</label>
            <textarea class="form-control" id="eventNote"></textarea>
          </div>
          <div class="form-group">
            <label for="startDate">วันที่และเวลาเริ่มต้น</label>
            <input type="datetime-local" class="form-control" id="startDate" required>
          </div>
          <div class="form-group">
            <label for="endDate">วันที่และเวลาสิ้นสุด</label>
            <input type="datetime-local" class="form-control" id="endDate" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="deleteEvent" class="btn btn-danger" style="display: none;">ลบ</button>  <!-- Initially hidden -->
        <button type="button" id="saveEvent" class="btn btn-primary">บันทึก</button>
      </div>
    </div>
  </div>
</div>



<!-- Include Bootstrap JS for modal functionality -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    
    $(document).ready(function() {

        
        // Initialize FullCalendar
        $('#calendar').fullCalendar({
            editable: true,
            selectable: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: 'load_events.php', // Script to load events from the database
            select: function(start, end) {
                $('#eventModalLabel').text('Add New Event');
                $('#eventForm')[0].reset();  // Clear the form
                $('#eventId').val('');
                $('#startDate').val(moment(start).format('YYYY-MM-DD HH:mm'));
                $('#endDate').val(moment(end).subtract(1, 'days').format('YYYY-MM-DD HH:mm'));
                $('#eventModal').modal('show');
            },
            eventClick: function(event) {
                $('#eventModalLabel').text('Edit Event');
                $('#eventId').val(event.id);
                $('#eventTitle').val(event.title);
                $('#eventSubTitle').val(event.subtitle);
                $('#taName').val(event.ta_name);
                $('#schoolName').val(event.school_name);
                $('#eventNote').val(event.note);
                $('#startDate').val(moment(event.start).format('YYYY-MM-DD HH:mm'));
                $('#endDate').val(moment(event.end).subtract(1, 'days').format('YYYY-MM-DD HH:mm'));
                $('#eventModal').modal('show');
            }
        });

        // Save event on modal save button click
        $('#saveEvent').click(function() {
            var id = $('#eventId').val();
            var title = $('#eventTitle').val();
            var subtitle = $('#eventSubTitle').val();
            var ta_name = $('#taName').val();
            var school_name = $('#schoolName').val();
            var note = $('#eventNote').val();
            var start_date = $('#startDate').val();
            var end_date = $('#endDate').val();

            if (title !== '') {
                $.ajax({
                    url: 'save_event.php',  // PHP script to handle insert or update
                    type: 'POST',
                    data: {
                        id: id,
                        title: title,
                        subtitle: subtitle,
                        ta_name: ta_name,
                        school_name: school_name,
                        note: note,
                        start_date: start_date,
                        end_date: end_date
                    },
                    success: function(response) {
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#eventModal').modal('hide');
                        alert(response);
                    }
                });
            }
        });

        // Delete event on modal delete button click
        $('#deleteEvent').click(function() {
            var id = $('#eventId').val();
            if (id !== '') {
                if (confirm("Are you sure you want to delete this event?")) {
                    $.ajax({
                        url: 'delete_event.php',  // PHP script to handle delete
                        type: 'POST',
                        data: {id: id},
                        success: function(response) {
                            $('#calendar').fullCalendar('refetchEvents');
                            $('#eventModal').modal('hide');
                            alert(response);
                        }
                    });
                }
            }
        });



        // Function to open modal for adding a new event
        function openNewEventModal() {
            // Clear the form
            document.getElementById('eventForm').reset();
            // Set eventId to empty, since it's a new event
            document.getElementById('eventId').value = '';
            // Hide the delete button
            document.getElementById('deleteEvent').style.display = 'none';
            // Show the modal
            $('#eventModal').modal('show');
        }

        // Function to open modal for editing an existing event
        function openEditEventModal(eventId) {
            // Fetch event details using eventId (from backend or your calendar data)
            // Example: Fill form fields with the existing event data
            document.getElementById('eventId').value = eventId;
            document.getElementById('eventTitle').value = 'Existing Event Title';  // Example data
            document.getElementById('eventSubTitle').value = 'Existing Subtitle';  // Example data
            // You can populate other fields similarly...

            // Show the delete button
            document.getElementById('deleteEvent').style.display = 'inline-block';
            // Show the modal
            $('#eventModal').modal('show');
        }

        // Example of calling the functions
        document.getElementById('addEventButton').addEventListener('click', openNewEventModal);
        // Call openEditEventModal(eventId) when an event is clicked for editing

    });
</script>

</body>
</html>
