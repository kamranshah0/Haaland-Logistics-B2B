# Haaland Logistics B2B - Mukammal Project Guide (Roman Urdu)

Ye document aapko is project ke har module aur un mein use hone wali har **Field** (boxes) ka maqsad samjhaye ga.

---

## 🏗️ 1. Warehouses (Origins)

Har warehouse wo spot hai jahan se shipping shuru hoti hai.

* **Name:** Warehouse ka poora naam (e.g., "Dubai Main Terminal").
* **Code:** Ek chota code pehchan ke liye (e.g., "DXB-01").
* **Address:** Warehouse ki physical location jahan client ko maal pahunchana hota hai.
* **Opening Hours:** Kab se kab tak ye warehouse maal accept karta hai.

## 📅 2. Departures (Schedules)

Ye sab se ahem module hai jo ship ke nikalne ka schedule track karta hai.

* **Vessel Name:** Us jahaz (ship) ka naam jis par maal load hoga.
* **Voyage Number:** Har safar ka ek unique ID hota hai taake record rakha ja sake.
* **Cut-off Date:** **Bohat Ahem!** Wo aakhri tareekh jab tak warehouse maal kabool kare ga. Iske baad booking band ho jati hai.
* **Departure Date (ETD):** Estimated Time of Departure - Wo tareekh jab jahaz port se nikal jaye ga.
* **Arrival Date (ETA):** Estimated Time of Arrival - Wo tareekh jab jahaz manzil (destination) par pohanche ga.
* **Capacity (CFT):** Jahaz mein total kitni jagah (Cubic Feet) available hai.
* **Status:** "Open" (bookings jaari hain), "Closed" (jagah bhar gayi hai), ya "Arrived" (pohanch gaya).

## 💰 3. Rates (Pricing System)

Admin yahan se tay karta hai ke kiraya kya hoga.

* **Origin:** Kis warehouse se kaam shuru ho raha hai.
* **Destination (Country/Region):** Maal kahan ja raha hai.
* **Service & Type:** Kya ye Sea Cargo hai? Kya ye Door-to-Door hai?
* **Rate per CFT:** Har 1 Cubic Foot ka kitna kiraya ($ ya AED mein).
* **Tiers (Weight/Volume):** Agar ziada maal ho to discount (maslan 100 CFT se upar rate sasta ho jaye ga).

## 📬 4. Inquiries / Quotes (Calculation)

Jab client price check karta hai.

* **Dimensions (L x W x H):** Box ki Lambai, Chorai, aur Unchai.
* **No. of Items:** Kitne boxes hain.
* **Total Volume (CFT):** System khud in box sizes ko multiply kar ke total jagah nikalta hai.
* **Total Bill:** Rate aur Volume ko multiply kar ke final amount.

## 🚢 5. Services & Types

* **Shipping Service:** Main rasta (e.g., Sea Freight, Air Freight).
* **Service Type:** Delivery ka tareeqa (e.g., "Door to Door" ya "Port to Port").

## ⚙️ 6. Operations (Booking Control)

Management yahan se kaam chalati hai.

* **Booking Status:** "Pending" (intezar), "Approved" (mannzoor), "Shipped" (jahaz par charh gaya).
* **Tracking Number:** Client ke liye unique number taake wo dekh sake maal kahan hai.
* **Utilized Capacity:** Ye batata hai ke "Departures" mein se kitni jagah bhar chuki hai aur kitni baki hai.

---

### **Asal Zindagi Mein Misal (Real-Life Example):**

Farz karein aapne Dubai se Karachi 10 box bhejne hain:

1. Aap **Warehouse** (Dubai) select karein ge.
2. System **Rates** check kare ga ($5 per CFT).
3. Aap boxes ka size dalein ge (**Quote/Inquiry**).
4. Admin aapko bataye ga ke "Agla jahaz (**Departure**) 25 tareekh ko nikal raha hai, lekin aapko 22 tareekh (**Cut-off Date**) tak maal dena hoga."
5. Jab aap maal de dein ge, to **Operations** mein aapki booking "Shipped" kar di jaye gi.

---

*Tayyar Karda: Antigravity AI Guide*
