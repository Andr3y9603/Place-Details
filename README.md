# Google Places Information — plugin for Craft CMS 3.x
----
#### Setup
1. Go to ```Settings > Place Details```
2. Add Google Place Api key 
3. Add Place Id
4. Setup Format, default is ```%day%: %open% - %close%``` Ex: ```Monday: 10:00 AM - 12:00 AM```
5. Setup 24 hour format
6. Translate days in table

#### Template
1. Global Vars
    - Object ```placeDetails```
    - Keys:
            - ```city```
            - ```sublocality```
            - ```country```
            - ```foramtted_address```
            - ```phone```
            - ```postal_code```
            - ```open_now```
            - ```opening_hours```
