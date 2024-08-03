<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleLocationActionQuickLinkCategory: string implements \JsonSerializable
{

    case QUICKLINKS_AIRLINE_BOOK_TRAVEL = 'quicklinks.airline_book_travel';//Book Travel
    case QUICKLINKS_AIRLINE_CHECK_IN = 'quicklinks.airline_check_in';//Check in
    case QUICKLINKS_AIRLINE_FLIGHT_STATUS = 'quicklinks.airline_flight_status';//Flight Status
    case QUICKLINKS_BOOK = 'quicklinks.book';//Book
    case QUICKLINKS_BOOK_ACTIVITIES = 'quicklinks.book.activities';//Activities
    case QUICKLINKS_BOOK_RIDES = 'quicklinks.book.rides';//Book Ride
    case QUICKLINKS_BOOK_TEETIMES = 'quicklinks.book.teetimes';//Tee Time
    case QUICKLINKS_BOOK_TOURS = 'quicklinks.book.tours';//Book Tour
    case QUICKLINKS_BUY_TICKETS = 'quicklinks.buy_tickets';//Tickets
    case QUICKLINKS_CAREERS = 'quicklinks.careers';//Careers
    case QUICKLINKS_CHARGE_EV = 'quicklinks.charge_ev';//Charge
    case QUICKLINKS_COUPONS = 'quicklinks.coupons';//Coupons
    case QUICKLINKS_DONATE = 'quicklinks.donate';//Donate
    case QUICKLINKS_EVENTS = 'quicklinks.events';//Events
    case QUICKLINKS_EVENTS_SHOWS = 'quicklinks.events.shows';//Shows
    case QUICKLINKS_EVENTS_SPORTS = 'quicklinks.events.sports';//Sports
    case QUICKLINKS_GIFT_CARD = 'quicklinks.gift_card';//Gift Card
    case QUICKLINKS_HOTEL_AMENITIES = 'quicklinks.hotel_amenities';//Amenities
    case QUICKLINKS_HOTEL_BOOK_ROOM = 'quicklinks.hotel_book_room';//Book
    case QUICKLINKS_PARKING_AVAILABLE_PARKING = 'quicklinks.parking_available_parking';//Parking
    case QUICKLINKS_PARKING_RESERVE_PARKING = 'quicklinks.parking_reserve_parking';//Reserve
    case QUICKLINKS_RESTAURANT_JOIN_WAITLIST = 'quicklinks.restaurant_join_waitlist';//Waitlist
    case QUICKLINKS_RESTAURANT_ORDER_DELIVERY = 'quicklinks.restaurant_order_delivery';//Delivery
    case QUICKLINKS_RESTAURANT_ORDER_FOOD = 'quicklinks.restaurant_order_food';//Order
    case QUICKLINKS_RESTAURANT_PICKUP = 'quicklinks.restaurant_pickup';//Pickup
    case QUICKLINKS_RESTAURANT_RESERVATION = 'quicklinks.restaurant_reservation';//Reserve
    case QUICKLINKS_RESTAURANT_VIEW_MENU = 'quicklinks.restaurant_view_menu';//Menu
    case QUICKLINKS_RETAIL_SERVICE_QUOTE = 'quicklinks.retail_service_quote';//Quote
    case QUICKLINKS_RETAIL_STORE_DELIVERY = 'quicklinks.retail_store_delivery';//Delivery
    case QUICKLINKS_RETAIL_STORE_PICKUP = 'quicklinks.retail_store_pickup';//Pickup
    case QUICKLINKS_RETAIL_STORE_SHOP = 'quicklinks.retail_store_shop';//Order
    case QUICKLINKS_SCHEDULE_APPOINTMENT = 'quicklinks.schedule_appointment';//Schedule
    case QUICKLINKS_SERVICES = 'quicklinks.services';//Services
    case QUICKLINKS_SUPPORT = 'quicklinks.support';//Support
    case QUICKLINKS_THEATER_NOW_PLAYING = 'quicklinks.theater_now_playing';//Showtimes
    case QUICKLINKS_VIEW_AVAILABILITY = 'quicklinks.view_availability';//Availability
    case QUICKLINKS_VIEW_PRICING = 'quicklinks.view_pricing';//Pricing

    public function jsonSerialize(): string{
        return $this->value;
    }
}
