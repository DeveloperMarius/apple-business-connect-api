<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleLocationCallToActionType implements \JsonSerializable
{
    //case category;//theme,ui_button_text.showcase.valid_for_use_apple_categories.description.quicklink.type.valid_for_use_primary_cta?
    case ADD_PHOTO;//Place Card Buttons,Add Photos.Add Photos.All.Feature that allows user to add a photo of a location.quicklinks.add_photos.Primary.N
    case ADD_TO_FAVORITES;//Place Card Buttons,Add to Favorites.Add to Favorites.All.Feature that allows user to add a location to their favorite locations.quicklinks.add_favorites.Primary.N
    case ADD_TO_GUIDE;//Place Card Buttons,Add to Guides.Add to Guide.All.Feature that allows user to add a location to a guide.quicklinks.add_guides.Primary.N
    case CALL;//Place Card Buttons,Call.Call Now.All.Feature that allows user to call a location.quicklinks.call.Primary.N
    case CREATE_NEW_CONTACT;//Place Card Buttons,Create New Contact.Save as Contact.All.Feature that allows user to add a location as a new contact.quicklinks.new_contact.Primary.N
    case DIRECTIONS;//Place Card Buttons,Directions.Get Directions.All.Feature that allows user to get directions to a location.quicklinks.directions.Primary.N
    case MESSAGE;//Place Card Buttons,Message.Message Us.All.Feature that allows user to message a location.quicklinks.message.Primary.N
    case RATE_THIS_PLACE;//Place Card Buttons,Recommend This Place.Rate Us.All.Feature that allows user to rate a location.quicklinks.recommend.Primary.N
    case SHARE;//Place Card Buttons,Share.Share This Place.All.Feature that allows user to share a location.quicklinks.share.Primary.N
    case WEBSITE;//Place Card Buttons,Website.More Info.All.Feature to allow user to open a location’s website.quicklinks.website.Primary.N
    case DELIVERY;//Food,Delivery.Order Delivery.All.Feature that  allows user to place a delivery order from a restaurant.quicklinks.restaurant_order_delivery.Quick Link/App Clip.Y
    case MENU;//Food,Menu.See Our Menu.All.Feature that allows user to view a restaurant menu, possibly in PDF format, that does not have ordering capability.quicklinks.restaurant_view_menu.Quick Link/App Clip.Y
    case ORDER;//Food,Order.Order Now.All.Feature that allows user to order food from a restaurant.quicklinks.restaurant_order_food.Quick Link/App Clip.Y
    case RESERVE_TABLE;//Food,Reserve.Reserve Now.All.Feature that allows user to reserve a table.quicklinks.restaurant_reservation.Quick Link/App Clip/App Ext.Y
    case WAITLIST;//Food,Waitlist.Join Waitlist.All.Feature to allow user to join a waitlist at a restaurant.quicklinks.restaurant_join_waitlist.Quick Link/App Clip.Y
    case PICKUP;//Food,Pickup.Order Pickup.All.Feature to allow user to place a takeout/pickup order from a restaurant..quicklinks.restaurant_pickup..Y
    case TICKETS;//Purchase,Tickets.Get Tickets.All.Feature to allow user to purchase tickets.quicklinks.buy_tickets.Quick Link/App Clip.Y
    case PARKING;//Purchase,Reserve.Find Parking.All.Feature that allows user to reserve a parking spot.quicklinks.parking_reserve_parking.Quick Link/App Clip.Y
    case AVAILABILITY;//Retail,Availability.Check Availability.All.Feature that allows user to see availability of a service. E.g. parking.quicklinks.view_availability.Quick Link/App Clip.Y
    case PRICING;//Retail,Pricing.See Pricing.All.Feature that allows user to view cost of a service, e.g. Parking, EV charging, but not pay.quicklinks.view_pricing.Quick Link/App Clip.Y
    case SCHEDULE;//Retail,Schedule.Make an Appointment.All.Feature to allow user to reserve a time for a service.quicklinks.schedule_appointment.Quick Link/App Clip.Y
    case ORDER_RETAIL;//Retail,Shop.Order Now.All.Feature that allows user to browse and purchase items.quicklinks.retail_store_shop..Y
    case SHOWTIMES;//Retail,Showtimes.See Showtimes.All.Feature that allows user to view showtimes.quicklinks.theater_now_playing.Quick Link/App Clip.Y
    case CHECK_IN;//Travel,Check In.Check In Now.hotelstravel.airports[*].Feature that allows user to check-in for flights and hotels.quicklinks.airline_check_in..Y
    case FLIGHT_STATUS;//Travel,Flight Status.Check Flight Status.hotelstravel.airports[*].Service for obtaining the current status for a flight.quicklinks.airline_flight_status..Y
    case RESERVE_ROOM;//Travel,Book.Reserve a Room.All.Feature that allows user to book a room at a hotel or accommodation.quicklinks.hotel_book_room.Quick Link/App Clip.Y

    public function jsonSerialize(): string{
        return $this->name;
    }
}
