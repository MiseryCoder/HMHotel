    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];
    $(function() {
        // if (!!scheds) {
        //     Object.keys(scheds).map(k => {
        //         var row = scheds[k]
        //         events.push({ id: row.booking_id, title: row.user_name + ' - ' + row.booking_status, start: row.check_in, end: row.check_out });
        //     })
        // }
        // var date = new Date()
        // var d = date.getDate(),
        //     m = date.getMonth(),
        //     y = date.getFullYear()

        // calendar = new Calendar(document.getElementById('calendar'), {
        //     headerToolbar: {
        //         left: 'prev,next today',
        //         right: 'dayGridMonth,dayGridWeek,list',
        //         center: 'title',
        //     },
        //     selectable: true,
        //     themeSystem: 'bootstrap',
        //     //Random default events
        //     events: events,
        //     eventClick: function(info) {
        //         var _details = $('#event-details-modal')
        //         var id = info.event.id
        //         if (!!scheds[id]) {
        //             _details.find('#title').text(scheds[id].room_name)
        //             _details.find('#description').text(scheds[id].booking_status)
        //             _details.find('#name').text(scheds[id].user_name)
        //             _details.find('#start').text(scheds[id].sdate)
        //             _details.find('#end').text(scheds[id].edate)
        //             _details.find('#edit,#delete').attr('data-id', id)
        //             _details.modal('show')
        //         } else {
        //             alert("Event is undefined");
        //         }
        //     },
        //     eventDidMount: function(info) {
        //         const event = info.event;
        //         const bookingStatus = event.extendedProps.title; // Get the booking_status from the event

        //         // Check if the booking_status is 'No Show' or 'Booked'
        //         if (bookingStatus === 'No Show' || bookingStatus === 'Booked') {
        //             // Get the DOM element representing the event's title
        //             const eventTitleElement = info.el.querySelector('.fc-event-title');

        //             // Change the background color based on booking_status
        //             if (bookingStatus === 'No Show') {
        //                 eventTitleElement.style.backgroundColor = '#ffc107';
        //             } else if (bookingStatus === 'Booked') {
        //                 eventTitleElement.style.backgroundColor = '#198754';
        //             }

        //             // Optionally, you can change the text color as well
        //             eventTitleElement.style.color = '#fff';
        //         }
        //     },
        //     editable: true
        // });

        // calendar.render();




        $(function() {
            if (!!scheds) {
                Object.keys(scheds).map(k => {
                    var row = scheds[k];
                    events.push({
                        id: row.booking_id,
                        title: row.user_name + ' - ' + row.booking_status,
                        title2: row.booking_status, // Add title2 property to store booking_status
                        start: row.check_in,
                        end: row.check_out
                    });
                });
            }

            var date = new Date();
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();

            calendar = new Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    
                },
                selectable: true,
                themeSystem: 'bootstrap',
                // Random default events
                events: events,
                eventClick: function(info) {
                    var _details = $('#event-details-modal')
                    var id = info.event.id
                    if (!!scheds[id]) {
                        _details.find('#title').text(scheds[id].room_name)
                        _details.find('#description').text(scheds[id].booking_status)
                        _details.find('#name').text(scheds[id].user_name)
                        _details.find('#start').text(scheds[id].sdate)
                        _details.find('#end').text(scheds[id].edate)
                        _details.find('#edit,#delete').attr('data-id', id)
                        _details.modal('show')
                    } else {
                        alert("Event is undefined");
                    }
                },
                eventDidMount: function(info) {
                    const event = info.event;
                    const bookingStatus = event.extendedProps.title2; // Use title2 property to get the booking_status

                    // Check if the booking_status is 'No Show' or 'Booked'
                    if (bookingStatus === 'No Show' || bookingStatus === 'Booked') {
                        // Get the DOM element representing the event's title
                        const eventTitleElement = info.el.querySelector('.fc-event-title');

                        // Change the background color based on booking_status
                        if (bookingStatus === 'No Show') {
                            eventTitleElement.style.backgroundColor = '#0dcaf0';
                        } else if (bookingStatus === 'Booked') {
                            eventTitleElement.style.backgroundColor = '#198754';
                        } else if (bookingStatus === 'Checked-Out') {
                            eventTitleElement.style.backgroundColor = '#C107FF';
                        } else if (bookingStatus === 'Checked-In') {
                            eventTitleElement.style.backgroundColor = '#ffc107';
                        } else if (bookingStatus === 'Reserved') {
                            eventTitleElement.style.backgroundColor = '#000';
                        } else if (bookingStatus === 'Cancelled') {
                            eventTitleElement.style.backgroundColor = '#dc3545';
                        }

                        // Optionally, you can change the text color as well
                        eventTitleElement.style.color = '#fff';
                    }
                },
                editable: true
            });

            calendar.render();
        });
    })