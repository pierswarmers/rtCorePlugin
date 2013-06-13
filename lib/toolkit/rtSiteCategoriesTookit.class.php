<?php

class rtSiteCategoriesToolkit {

    private $categories =
        array(
            "Accommodation" => array(
                "hotels" => "Hotels",
                "motels" => "Motels",
                "bed-breakfast" => "Bed & Breakfast",
                "resorts" => "Holiday Resorts",
                "self-catering" => "Serviced Apartments",
                "camping-grounds-caravans" => "Campgrounds & Caravan Parks",
                "hostels" => "Hostels",
                "aged-care" => "Aged Care Accommodation",
                "mobile-homes" => "Mobile Homes",
                "crisis-care" => "Crisis Care Accommodation",
            ),
            "Adult" => array(
                "adult-services" => "Adult Services",
                "adult-retail" => "Adult Novelties & Products Retail",
                "dating-agency" => "Dating Agency",
                // "escorts" => "Escorts Agency",
            ),
            "Arts & Entertainment" => array(
                "pubs-bars" => "Pubs & Bars",
                "cinemas" => "Cinema",
                "galleries" => "Art Galleries",
                "amusement-parks" => "Amusement Parks",
                "aquariums" => "Aquariums",
                "astrology-services" => "Astrology, Spiritual & Genealogy",
                "bingo" => "Bingo",
                "bookies" => "Bookies",
                "gardens" => "Botanical Gardens",
                "casinos" => "Casinos",
                "circus" => "Circus",
                "comedy-clubs" => "Comedy Clubs",
                "hobbies" => "Interest Groups",
                "landmarks" => "Landmarks & Historical Buildings",
                "museums" => "Museums",
                "music-venues" => "Music Venues",
                "night-club" => "Nightclub",
                "stadiums-arenas" => "Stadiums & Arenas",
                "theatres" => "Theatres",
                "zoos" => "Zoos",
            ),
            "Automotive" => array(
                "mechanic" => "Mechanic",
                "car-parking" => "Parking",
                "towing" => "Towing",
                "car-dealers" => "Car Dealers",
                "car-wash" => "Car Wash",
                "motor-cycle-dealers" => "Motorcycle & Scooter Dealers",
                "motor-cycle-repair" => "Motorcycle & Scooter Repair",
                "mufflers-exhaust" => "Mufflers & Exhaust Systems",
                "petrol-service-stations" => "Petrol & Service Stations",
                "road-assistance" => "Roadside Assistance",
                "towbar" => "Towbar Fitting",
                "tyres" => "Tyres",
                "motor-vehicle-battery" => "Vehicle Batteries",
                "body-work" => "Vehicle Body Work",
                "brake-clutch-repairs" => "Vehicle Brake & Clutch Repairs",
                "auto-electrical" => "Vehicle Electrical Repairs",
                "vehicle-inspections" => "Vehicle Inspections",
                "radiators" => "Vehicle Radiators",
                "spare-parts" => "Vehicle Spare Parts",
                "gearbox-repair" => "Vehicle Transmission & Gearbox Repairs",
                "windscreens" => "Windscreens",
            ),
            "Domestic Services" => array(
                "childcare" => "Child Care & Day Care",
                "dry-cleaning-laundry" => "Dry Cleaning & Laundry",
                "pest-control" => "Pest Control",
                "home-appliance-repair" => "Appliances & Repair",
                "non-profit" => "Community Service/Non-Profit",
                "funeral-services" => "Funeral Services & Cemeteries",
                "home-minding" => "Home Minding",
                "rubbish-waste-removal" => "Rubbish & Waste Removal",
                "sewing-alterations" => "Sewing & Alterations",
                "shoe-repair" => "Shoe Repair",
                "self-storage" => "Storage",
                "trophies-engraving" => "Trophies & Engraving",
                "upholstering-polishing" => "Upholstering & Polishing",
                "watch-repair" => "Watch Repair",
            ),
            "Education & Learning" => array(
                "schools" => "Schools",
                "tafe" => "TAFE",
                "university" => "Universities",
                "adult-education" => "Adult Education",
                "art-schools" => "Art Schools",
                "colleges" => "Colleges",
                "cooking-schools" => "Cooking Schools",
                "dance-schools" => "Dance Schools",
                "drama-school" => "Drama School",
                "driving-schools" => "Driving Schools",
                "first-aid" => "First Aid Training",
                "flying-school" => "Flying Schools",
                "preschools" => "Kindergarten & Preschools",
                "language-schools" => "Language Schools",
                "motorcycle-training" => "Motorcycle Training",
                "music-schools" => "Music Schools",
                "riding-schools" => "Riding Schools",
                "specialty-schools" => "Special Schools",
                "tutoring" => "Tutoring",
                "research" => "Research"
            ),
            "Event Organisation" => array(
                "wedding-planning" => "Wedding Planning",
                "wedding-supplies" => "Wedding Supplies",
                "party-supplies" => "Party Supplies",
                "event-planning" => "Party & Event Planning",
                "boat-charters" => "Boat Charters",
                "catering" => "Caterers",
                "costume-hire" => "Costumes & Formal Wear",
                "dj" => "DJs",
                "film-production" => "Film Production",
                "photographers" => "Photographers",
                "venues" => "Venues & Event Spaces",
        ), "Financial Services" => array(

            "atm" => "ATM",
            "bookkeeping" => "Bookkeeping",
            "banks" => "Banks",
            "mortgage" => "Mortgage Brokers",
            "building-societies" => "Building Societies",
            "credit-unions" => "Credit Unions",
            "insurance" => "Insurance",
            "invest" => "Investing",
            "debt-collection" => "Debt Collecting",
            "refinancing" => "Refinancing",
            "currency-exchange" => "Foreign Currency Exchange",

        ), "Food & Beverages" => array(

            "supermarket-grocery" => "Supermarket & Grocery Stores",
            "bottle-shop" => "Bottle Shops",
            "fruit-and-vegetable" => "Fruits & Vegetables",
            "brewery" => "Breweries",
            "butchers" => "Butchers",
            "chocolate" => "Chocolatiers",
            "coffee-tea" => "Coffee & Tea Suppliers",
            "confectionary" => "Confectionery",
            "convenience" => "Convenience Stores",
            "delis" => "Delis",
            "farmers-market" => "Farmers Market",
            "gourmet" => "Gourmet",
            "health-markets" => "Health Markets",
            "ice-cream" => "Ice Cream & Frozen Yogurt",
            "juice-bars" => "Juice Bars",
            "seafood" => "Seafood",
            "special-food" => "Specialty Food",
            "vineyards" => "Vineyards & Wineries",
            "dairy-products" => "Dairy Products",
            "cake-shop" => "Cake Shop",
            "bakeries" => "Bakeries",

        ), "Government" => array(

            "federal-government" => "Federal Government",
            "local-government" => "Local Government",
            "state-government" => "State Government",
            "political-party" => "Political Party",
            "embassies" => "Consulates & Embassies",
            "attorney-general" => "Attorney General",
            "justice" => "Justice",
            "prison" => "Prison",
            "police" => "Police",
            "emergency-services" => "Emergency Services",
            "education" => "Education",
            "family-community-services" => "Family and Community Services",
            "libraries" => "Libraries",
            "finance" => "Finance and Services",
            "health" => "Health",
            "primary-industries" => "Primary Industries",
            "transport" => "Transport",
            "treasury" => "The Treasury",
            "military-defense" => "Military & Defence",

        ), "Hair & Beauty" => array(

            "beauty-salons" => "Beauty Salons",
            "spas" => "Day Spas",
            "hairdressers" => "Hairdressers",
            "hair-removal" => "Hair Removal",
            "makeup-artists" => "Makeup Artists",
            "massage" => "Massage",
            "manicure" => "Nail Salon",
            "piercing" => "Piercing",
            "skin-care" => "Skin Care",
            "tanning" => "Tanning Salons",
            "tattoos" => "Tattooists",

        ), "Manufacturing & Agriculture" => array(

            "clothing-manufacturer" => "Clothing Manufacturers",
            "footwear-manufacturer" => "Footwear Manufacturers",
            "sporting-goods" => "Sporting Goods Manufacturers",
            "agriculture" => "Agriculture",
            "animal-breeding" => "Animal Breeding",
            "beverage-manufacturer" => "Beverage Manufacturers",
            "concrete-plaster-manufacturer" => "Cement, Lime, Plaster & Concrete Manufacturers",
            "ceramic-manufacturer" => "Ceramic Manufacturers",
            "chemical-manufacturer" => "Chemical Manufacturers",
            "cosmetics-manufacturer" => "Cosmetics Manufacturers",
            "electronic-appliance-manufacturer" => "Electronic Equipment & Appliance Manufacturers",
            "fabric-textiles-manufacturer" => "Fabric Manufacturers",
            "farming" => "Farming",
            "furniture-manufacturer" => "Furniture Manufacturers",
            "general-manufacturer" => "General Manufacturers",
            "glass-manufacturer" => "Glass Manufacturers",
            "machinery-tools" => "Machinery & Tools Manufacturers",
            "metal-manufacturer" => "Metal Manufacturers",
            "mining" => "Mining",
            "oil-gas" => "Oil & Gas",
            "other-manufacturer" => "Other Manufacturers",
            "paper-manufacturer" => "Paper Manufacturers",
            "plastic-fibreglass" => "Plastic & Fibreglass Manufacturers",
            "quarry" => "Quarrying",
            "rubber-manufacturer" => "Rubber Manufacturers",
            "timber-forestry" => "Timber & Forestry",
            "transport-manufacturer" => "Transport Manufacturers",

        ), "Media & Communication" => array(

            "couriers" => "Couriers",
            "internet" => "Internet Services",
            "telephone" => "Telephone Services",
            "internet-publisher" => "Internet Publisher",
            "post-offices" => "Post Offices",
            "print-media" => "Print Media",
            "radio-stations" => "Radio Stations",
            "recorded-media" => "Recorded Media & Publishing",
            "recording-studios" => "Recording & Rehearsal Studios",
            "tv-stations" => "Television Stations",
            "writer" => "Written Communication",

        ), "Medical" => array(

            "dentists" => "Dentists",
            "mobility-aids" => "Mobility Aids",
            "doctors" => "Doctors",
            "medical-centres" => "Medical Centres",
            "acupuncture" => "Acupuncture",
            "alternative-medicine" => "Alternative Medicine",
            "cardiology" => "Cardiologists",
            "chiropodist" => "Chiropodist",
            "chiropractors" => "Chiropractors",
            "cosmetic-surgeons" => "Cosmetic Surgeons",
            "counselling" => "Counselling & Mental Health",
            "dermatologist" => "Dermatologists",
            "hospitals" => "Hospitals",
            "pregnancy-maternity" => "Pregnancy & Maternity Services",
            "obstetrician-gynaecologist" => "Obstetricians & Gynaecologists",
            "ophthalmologists" => "Ophthalmologists",
            "opticians" => "Opticians",
            "oral-surgeons" => "Oral Surgeons",
            "orthodontists" => "Orthodontists",
            "paediatrician" => "Paediatricians",
            "pathology" => "Pathologist",
            "physiotherapist" => "Physiotherapy",
            "podiatrists" => "Podiatrists",
            "abortions" => "Pregnancy Termination Service",
            "psychiatrists" => "Psychiatrists",
            "specialist-medical-services" => "Specialist Medical Services",
            "sports-medicine" => "Sports Medicine",
            "weight-loss" => "Weight Loss Treatment",

        ), "Pets" => array(

            "pet-boarding" => "Pet Boarding",
            "pet-care" => "Pet Care",
            "pet-training" => "Pet Training",
            "vet" => "Veterinarians",
            "dog-walkers" => "Dog Walkers",
            "pet-funerals" => "Pet Funerals",
            "groomer" => "Pet Groomers",
            "pet-shop" => "Pet Shops",

        ), "Professional Services" => array(

            "accountants" => "Accountants",
            "business-broker" => "Business Broker",
            "association" => "Associations & Unions",
            "real-estate-agents" => "Real Estate Agents",
            "advertising" => "Advertising",
            "building-design" => "Building Designers",
            "consultant" => "Business Consultancy",
            "business-opportunities" => "Business Opportunities",
            "business-services" => "Business Services",
            "casting-celebrity" => "Celebrity Management & Casting",
            "private-detective" => "Detective & Investigator Services",
            "recruitment-agency" => "Employment Agency",
            "engineering" => "Engineering",
            "environmental-consultant" => "Environmental Consultancy",
            "fashion" => "Fashion",
            "graphic-design" => "Graphic Design",
            "import-export" => "Import & Export Agents",
            "translation" => "Interpreting & Translating",
            "it-services" => "IT Services",
            "lawyers" => "Lawyers",
            "legal" => "Legal Services",
            "local-search" => "Local Search Directory",
            "marketing" => "Marketing",
            "printers" => "Printers",
            "property-management" => "Property Management",
            "pr" => "Public Relations",
            "science" => "Science",
            "security-services" => "Security Services",
            "surveyors" => "Surveyors",
            "web-design" => "Web Design",
            "web-hosting" => "Web Hosting",
            "professional-services" => "Professional Services",
            "corporate-office" => "Office",
            "computer-services" => "Computer Services & Repair",

        ), "Religion" => array(

            "church" => "Churches",
            "mosque" => "Mosques",
            "synagogue" => "Synagogues",
            "temple" => "Temples",
            "religion" => "Religious Organisations",

        ), "Restaurants" => array(

            "cafe" => "Cafes",
            "restaurants" => "Restaurants",
            "take-away" => "Takeaways",

        ), "Retail Shopping" => array(

            "florists" => "Florists",
            "mobile-phones" => "Mobile Phones Retailers",
            "shopping-centres" => "Shopping Centres",
            "antiques" => "Antiques Retailers",
            "arts-crafts" => "Arts & Crafts Retailers",
            "art-supplies" => "Art Supplies Retailers",
            "stationery" => "Stationery Retailers",
            "fabric-stores" => "Fabric Stores",
            "frames" => "Framing",
            "book-shop" => "Bookstores",
            "comic-books" => "Comic Books Retailers",
            "newsagent" => "Newsagents",
            "movie-games-rental" => "Movies & Video Game Rental",
            "bridal" => "Bridal Wear Retailers",
            "computers" => "Computers Retailers",
            "cosmetics" => "Cosmetics & Beauty Retailers",
            "department-store" => "Department Stores",
            "pharmacy" => "Chemists",
            "household-appliances" => "Household Appliances Retailers",
            "home-entertainment" => "Home Entertainment Retailers",
            "eyewear" => "Eyewear Retailers",
            "clothing-retailers" => "Clothing Retailers",
            "leather" => "Leather Goods Retailers",
            "lingerie" => "Lingerie Retailers",
            "maternity" => "Maternity Retailers",
            "shoes" => "Shoe Stores",
            "second-hand-clothes" => "Used, Vintage & Consignment Clothing Retailers",
            "cards-gift-shop" => "Cards & Gift Shops",
            "hobby-shops" => "Hobby Shops",
            "furniture" => "Furniture Stores",
            "hardware" => "Hardware Stores",
            "home-decor" => "Home Decor Retailers",
            "kitchen-bath" => "Kitchen & Bath Retailers",
            "gardening" => "Nurseries & Gardening Retailers",
            "jewellery-watches" => "Jewellery & Watch Retailers",
            "luggage" => "Luggage Retailers",
            "musical-instruments" => "Musical Instruments Retailers",
            "office-equipment" => "Office Equipment Retailers",
            "camera-stores" => "Photography Stores",
            "bike" => "Bike Shops",
            "outdoor-gear" => "Outdoor Gear Retailers",
            "sports-goods" => "Sporting Goods Retailers",
            "tobacco-shops" => "Tobacco Shops",
            "toys-computer-games" => "Toys & Computer Games Retailers",
            "photo" => "Photo Film Processing",
            "wholesalers" => "Wholesalers",
            "boat" => "Boat Dealers",
            "factory-outlets" => "Factory Outlets",
            "used-goods-retailers" => "Used Goods Retailers",
            "general-retailing" => "General Retailers",
            "promotional-products" => "Promotional Products",
            "caravan" => "Caravan Dealers",
            "trailer-retailer" => "Trailer Dealers",
            "music-video-dvd" => "Music & DVD's Retailers",

        ), "Sports & Recreation" => array(

            "extreme-sports" => "Extreme Sports",
            "gyms" => "Gyms & Fitness Centres",
            "surf-school" => "Surf School",
            "personal-trainer" => "Personal Trainers",
            "swimming-pools" => "Swimming Pools",
            "beaches" => "Beaches",
            "parks" => "Parks",
            "play-grounds" => "Playgrounds",
            "racing" => "Racing",
            "boats-yachts" => "Boating",
            "bowling" => "Bowling",
            "martial-arts" => "Martial Arts",
            "pilates" => "Pilates",
            "pool-snooker" => "Pool Halls",
            "yoga" => "Yoga",
            "go-karting" => "Go Karting",
            "golf" => "Golf",
            "parachuting" => "Parachuting",
            "scuba-diving" => "Scuba Diving",
            "skating-rinks" => "Skating Rinks",
            "sports-club" => "Sports Clubs",
            "squash" => "Squash",
            "ski-snowboard" => "Skiing & Snowboarding",
            "tennis" => "Tennis",
            "bike-rentals" => "Bike Rentals",
            "fishing" => "Fishing",
            "paintball" => "Paintball",
            "archery" => "Archery",
            "badminton" => "Badminton",
            "gymnastics" => "Gymnastics",
            "water-skiing" => "Water Skiing",

        ), "Trades" => array(

            "electricians" => "Electricians",
            "handyman" => "Handyman",
            "removalists" => "Removalists",
            "building-supplies" => "Building Supplies",
            "flooring" => "Flooring",
            "construction" => "Construction Services",
            "gardeners" => "Gardeners",
            "cleaners" => "Cleaning",
            "interior-design" => "Interior Design",
            "locksmiths" => "Locksmiths",
            "landscaping" => "Landscaping",
            "indoor-renovation" => "Indoor Home Improvement",
            "outdoor-renovation" => "Outdoor Home Improvement",
            "painters" => "Painters",
            "plumbing" => "Plumbing",
            "blinds-awnings" => "Shades & Blinds",
            "tree-surgeon" => "Tree surgeon",
            "air-conditioning" => "Air Conditioning & Heating Installation",
            "roofing" => "Roofing",
            "installation" => "Installation Trade Services",
            "carpenter" => "Carpenter",
            "glazier" => "Glazier",
            "packing" => "Packing",
            "signwriting" => "Signwriting",
            "pools" => "Home Pools & Spas",
            "building-construction" => "Building Construction",
            "concrete-cement" => "Concrete & Cement",
            "bricklayer" => "Bricklaying",
            "earthmoving" => "Earthmoving",
            "security" => "Security & Safety System Installation",
            "fencing" => "Fencing Construction",
            "guttering" => "Guttering",
            "drainers" => "Drainers",
            "stonemason" => "Stonemason",
            "kitchen-renovation" => "Kitchen Renovation",
            "bathroom-renovation" => "Bathroom Renovation",
            "plastering" => "Plasterers",
            "tiling" => "Tiling",
            "insulation" => "Insulation",
            "refrigeration-installation" => "Refrigeration Installation & Repair",
            "office-fitout" => "Office Fitout & Installation",
            "audiovisual-installation" => "Audiovisual Equipment Installation",

        ), "Travel & Transport" => array(

            "car-rental" => "Car Rental",
            "airport-shuttle" => "Airport Shuttles",
            "taxi-cab" => "Taxis",
            "airlines" => "Airlines",
            "airports" => "Airports",
            "bus-coaches" => "Buses & Coaches",
            "caravan-hire" => "Caravan & Campervan Hire",
            "freight-transport" => "Freight Transportation",
            "limos" => "Limos",
            "ports-harbours" => "Ports & Harbours",
            "public-transport" => "Public Transportation",
            "ships" => "Ships",
            "tourist-attractions" => "Tourist Attractions",
            "tours" => "Tours",
            "trailer-hire" => "Trailer Hire",
            "travel-tourism" => "Travel & Tourism",
            "travel-agents" => "Travel Agents",

        ), "Utilities" => array(

            "electricity" => "Electricity Supply",
            "gas" => "Gas Supply",
            "sewage" => "Waste Treatment",
            "water" => "Water Utility",
        ));



    public function getCategories () {
        return $this->categories;
    }
}