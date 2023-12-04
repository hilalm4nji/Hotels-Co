  function cost(){
   // Extracting selected values from the HTML form
    var selectedHotel = document.getElementById('hotel').value;
    var adults = parseInt(document.getElementById("adult").value)
    var childs = parseInt(document.getElementById("child").value)
    var checkin = parseInt(document.getElementById("checkin-date").value)
    var checkout = parseInt(document.getElementById("checkout-date").value)
    const startDate = new Date(checkin);
    const endDate = new Date(checkout);
    var roomtype = parseInt(document.getElementById("room-selection").value)

    // Determining the cost per night based on the selected hotel
    var costPerNight;
    switch (selectedHotel) {
      case 'hotelA':
        costPerNight = 100;
        break;
      case 'hotelB':
        costPerNight = 150;
        break;
      case 'hotelC':
        costPerNight = 60;
        break; 
    case 'hotelD':
        costPerNight = 300;
        break;    
    default:
        costPerNight = 0;
    }

    // Calculating the base cost of the hotel stay
    var rescost = costPerNight * (adults + 5 * childs)

    // Calculating additional cost for room preference (connecting or not)
    var roomPreferenceCost = roomtype === "connecting" ? 5 : 0;

    // Calculating the duration of the stay in days
    const timeDifference = endDate - startDate;
    const numberOfDays = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

    // Calculating tax as 50% of the total cost
    var tax = (rescost + roomPreferenceCost + numberOfDays) * 0.5

    // Calculating the total cost including base cost, room preference, and tax
    var tCosts = rescost + roomPreferenceCost + numberOfDays + tax

    // Displaying the total cost in the HTML form
    document.getElementById("total").value = "$" + tCosts

}