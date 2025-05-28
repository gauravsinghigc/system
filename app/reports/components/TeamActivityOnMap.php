<div class="card-body">
   <h5 class="card-title app-sub-heading"><i class="fa fa-map-marker"></i> Activity On Map</h5>
   <div style="display: flex; align-items: center; margin-bottom: 20px;">
      <button onclick="scrollCalendar('left')" style="padding: 5px 10px; margin-right: 10px;">←</button>
      <div id="calendar" style="display: flex; overflow-x: auto; white-space: nowrap; width: 100%;">
         <div class="date-box" data-date="2025-05-22" style="flex: 0 0 auto; padding: 10px; margin: 5px; border: 1px solid #ddd; cursor: pointer; background-color: #f9f9f9; text-align: center; min-width: 80px;">22 May</div>
         <div class="date-box" data-date="2025-05-23" style="flex: 0 0 auto; padding: 10px; margin: 5px; border: 1px solid #ddd; cursor: pointer; background-color: #f9f9f9; text-align: center; min-width: 80px;">23 May</div>
         <div class="date-box" data-date="2025-05-24" style="flex: 0 0 auto; padding: 10px; margin: 5px; border: 1px solid #ddd; cursor: pointer; background-color: #f9f9f9; text-align: center; min-width: 80px;">24 May</div>
         <div class="date-box" data-date="2025-05-25" style="flex: 0 0 auto; padding: 10px; margin: 5px; border: 1px solid #ddd; cursor: pointer; background-color: #f9f9f9; text-align: center; min-width: 80px;">25 May</div>
         <div class="date-box" data-date="2025-05-26" style="flex: 0 0 auto; padding: 10px; margin: 5px; border: 1px solid #ddd; cursor: pointer; background-color: #e0e0e0; text-align: center; min-width: 80px;">26 May</div>
         <div class="date-box" data-date="2025-05-27" style="flex: 0 0 auto; padding: 10px; margin: 5px; border: 1px solid #ddd; cursor: pointer; background-color: #f9f9f9; text-align: center; min-width: 80px;">27 May</div>
         <div class="date-box" data-date="2025-05-28" style="flex: 0 0 auto; padding: 10px; margin: 5px; border: 1px solid #ddd; cursor: pointer; background-color: #f9f9f9; text-align: center; min-width: 80px;">28 May</div>
      </div>
      <button onclick="scrollCalendar('right')" style="padding: 5px 10px; margin-left: 10px;">→</button>
   </div>
   <div id="map" style="height: 400px; width: 100%; margin-bottom: 20px;"></div>
   <h6>Location Details</h6>
   <table style="width: 100%; border-collapse: collapse;">
      <thead>
         <tr>
            <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Location Name</th>
            <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Latitude</th>
            <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Longitude</th>
            <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Date</th>
            <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Time</th>
         </tr>
      </thead>
      <tbody id="location-table"></tbody>
   </table>
</div>
<script>
   // Initialize the map
   const map = L.map('map').setView([28.3521, 77.4746], 10); // Centered between Noida and Jewar
   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
   }).addTo(map);

   // Define locations for past 5 days (May 22–26, 2025)
   const locations = [
      // May 22
      {
         name: "Noida Sector 18",
         lat: 28.5372,
         lng: 77.3894,
         date: "2025-05-22",
         time: "09:30"
      },
      {
         name: "Jewar Airport",
         lat: 28.1701,
         lng: 77.5603,
         date: "2025-05-22",
         time: "10:00"
      },
      {
         name: "Greater Noida",
         lat: 28.4729,
         lng: 77.5012,
         date: "2025-05-22",
         time: "10:15"
      },
      {
         name: "Yamuna Expressway",
         lat: 28.2987,
         lng: 77.5481,
         date: "2025-05-22",
         time: "08:45"
      },
      {
         name: "Noida City Center",
         lat: 28.5732,
         lng: 77.3518,
         date: "2025-05-22",
         time: "09:50"
      },
      {
         name: "Sector 62 Noida",
         lat: 28.6218,
         lng: 77.3627,
         date: "2025-05-22",
         time: "10:20"
      },
      {
         name: "Noida Sector 137",
         lat: 28.5065,
         lng: 77.4102,
         date: "2025-05-22",
         time: "10:30"
      },
      {
         name: "Sector 16 Noida",
         lat: 28.5801,
         lng: 77.3176,
         date: "2025-05-22",
         time: "09:15"
      },
      // May 23
      {
         name: "Jewar Town",
         lat: 28.1223,
         lng: 77.5709,
         date: "2025-05-23",
         time: "10:10"
      },
      {
         name: "Noida Expressway",
         lat: 28.5967,
         lng: 77.3875,
         date: "2025-05-23",
         time: "09:40"
      },
      {
         name: "Noida Sector 18",
         lat: 28.5358,
         lng: 77.3902,
         date: "2025-05-23",
         time: "10:25"
      },
      {
         name: "Jewar Airport",
         lat: 28.1698,
         lng: 77.5590,
         date: "2025-05-23",
         time: "09:55"
      },
      {
         name: "Greater Noida",
         lat: 28.4740,
         lng: 77.5020,
         date: "2025-05-23",
         time: "10:35"
      },
      {
         name: "Sector 62 Noida",
         lat: 28.6220,
         lng: 77.3635,
         date: "2025-05-23",
         time: "09:20"
      },
      {
         name: "Noida City Center",
         lat: 28.5728,
         lng: 77.3525,
         date: "2025-05-23",
         time: "10:00"
      },
      {
         name: "Yamuna Expressway",
         lat: 28.2990,
         lng: 77.5475,
         date: "2025-05-23",
         time: "08:30"
      },
      // May 24
      {
         name: "Noida Sector 137",
         lat: 28.5070,
         lng: 77.4110,
         date: "2025-05-24",
         time: "10:40"
      },
      {
         name: "Sector 16 Noida",
         lat: 28.5795,
         lng: 77.3180,
         date: "2025-05-24",
         time: "09:25"
      },
      {
         name: "Jewar Town",
         lat: 28.1230,
         lng: 77.5715,
         date: "2025-05-24",
         time: "10:15"
      },
      {
         name: "Noida Expressway",
         lat: 28.5970,
         lng: 77.3880,
         date: "2025-05-24",
         time: "09:50"
      },
      {
         name: "Noida Sector 18",
         lat: 28.5365,
         lng: 77.3900,
         date: "2025-05-24",
         time: "10:20"
      },
      {
         name: "Jewar Airport",
         lat: 28.1705,
         lng: 77.5585,
         date: "2025-05-24",
         time: "09:45"
      },
      {
         name: "Greater Noida",
         lat: 28.4735,
         lng: 77.5005,
         date: "2025-05-24",
         time: "10:30"
      },
      // May 25
      {
         name: "Yamuna Expressway",
         lat: 28.2980,
         lng: 77.5485,
         date: "2025-05-25",
         time: "08:55"
      },
      {
         name: "Noida City Center",
         lat: 28.5735,
         lng: 77.3520,
         date: "2025-05-25",
         time: "10:05"
      },
      {
         name: "Sector 62 Noida",
         lat: 28.6225,
         lng: 77.3630,
         date: "2025-05-25",
         time: "09:35"
      },
      {
         name: "Noida Sector 137",
         lat: 28.5060,
         lng: 77.4105,
         date: "2025-05-25",
         time: "10:25"
      },
      {
         name: "Sector 16 Noida",
         lat: 28.5805,
         lng: 77.3170,
         date: "2025-05-25",
         time: "09:15"
      },
      {
         name: "Jewar Town",
         lat: 28.1225,
         lng: 77.5710,
         date: "2025-05-25",
         time: "10:10"
      },
      {
         name: "Noida Expressway",
         lat: 28.5965,
         lng: 77.3870,
         date: "2025-05-25",
         time: "09:40"
      },
      {
         name: "Noida Sector 18",
         lat: 28.5360,
         lng: 77.3890,
         date: "2025-05-25",
         time: "10:20"
      },
      // May 26
      {
         name: "Jewar Airport",
         lat: 28.1695,
         lng: 77.5595,
         date: "2025-05-26",
         time: "09:30"
      },
      {
         name: "Greater Noida",
         lat: 28.4730,
         lng: 77.5015,
         date: "2025-05-26",
         time: "10:45"
      },
      {
         name: "Yamuna Expressway",
         lat: 28.2985,
         lng: 77.5480,
         date: "2025-05-26",
         time: "08:50"
      },
      {
         name: "Noida City Center",
         lat: 28.5730,
         lng: 77.3515,
         date: "2025-05-26",
         time: "10:00"
      },
      {
         name: "Sector 62 Noida",
         lat: 28.6215,
         lng: 77.3620,
         date: "2025-05-26",
         time: "09:55"
      },
      {
         name: "Noida Sector 137",
         lat: 28.5068,
         lng: 77.4108,
         date: "2025-05-26",
         time: "10:35"
      },
      {
         name: "Sector 16 Noida",
         lat: 28.5798,
         lng: 77.3178,
         date: "2025-05-26",
         time: "09:20"
      },
      {
         name: "Jewar Town",
         lat: 28.1228,
         lng: 77.5712,
         date: "2025-05-26",
         time: "10:15"
      },
      {
         name: "Noida Expressway",
         lat: 28.5962,
         lng: 77.3872,
         date: "2025-05-26",
         time: "09:45"
      }
   ];

   let markers = [];
   let selectedDate = "2025-05-26"; // Default to most recent past date

   // Function to update map and table based on selected date
   function updateMapAndTable(date) {
      selectedDate = date;
      // Update calendar highlighting
      document.querySelectorAll('.date-box').forEach(box => {
         box.style.backgroundColor = box.getAttribute('data-date') === date ? '#e0e0e0' : '#f9f9f9';
      });

      // Clear existing markers
      markers.forEach(marker => map.removeLayer(marker));
      markers = [];

      // Filter locations for the selected date
      const filteredLocations = locations.filter(loc => loc.date === date);

      // Update table
      const tableBody = document.getElementById('location-table');
      tableBody.innerHTML = '';
      filteredLocations.forEach(location => {
         const row = document.createElement('tr');
         row.innerHTML = `
                <td style="border: 1px solid #ddd; padding: 8px;">${location.name}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">${location.lat.toFixed(4)}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">${location.lng.toFixed(4)}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">${location.date}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">${location.time}</td>
            `;
         tableBody.appendChild(row);

         // Add marker to map
         const marker = L.marker([location.lat, location.lng])
            .addTo(map)
            .bindPopup(`<b>${location.name}</b><br>Lat: ${location.lat.toFixed(4)}, Lng: ${location.lng.toFixed(4)}<br>Date: ${location.date}<br>Time: ${location.time}`);
         markers.push(marker);
      });

      // Adjust map view if there are locations
      if (filteredLocations.length > 0) {
         const group = L.featureGroup(markers);
         map.fitBounds(group.getBounds().pad(0.2));
      } else {
         map.setView([28.3521, 77.4746], 10); // Reset to default view
      }
   }

   // Scroll calendar function
   function scrollCalendar(direction) {
      const calendar = document.getElementById('calendar');
      const scrollAmount = 100; // Adjust scroll distance
      if (direction === 'left') {
         calendar.scrollLeft -= scrollAmount;
      } else {
         calendar.scrollLeft += scrollAmount;
      }
   }

   // Add click event listeners to date boxes
   document.querySelectorAll('.date-box').forEach(box => {
      box.addEventListener('click', () => {
         updateMapAndTable(box.getAttribute('data-date'));
      });
   });

   // Initialize with most recent past date
   updateMapAndTable(selectedDate);
</script>