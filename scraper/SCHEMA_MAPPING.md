# RJS Data → CI3 Database Schema Mapping

## Members (members.json → com_members)

| JSON Field | DB Column | Notes |
|---|---|---|
| `name` | `first_name` + `last_name` | Split on first space |
| `life_member_id` | `membership_no` | Direct map |
| `mobile` | `mobile` | 10-digit |
| `photo_url` | `photo` | Download → local filename |
| `type` | `membership_type` | "lifetime" or "executive" |
| — | `status` | Default: 1 |
| — | `is_deleted` | Default: 0 |

## Executive Members (executive_members.json → com_members)

| JSON Field | DB Column | Notes |
|---|---|---|
| `name` | `first_name` + `last_name` | |
| `designation` | `designation` | President, Secretary, etc. |
| `mobile` | `mobile` | |
| `address` | `address` | |
| `type` | `membership_type` | "executive" |

## Temples (temples.json → com_temples)

| JSON Field | DB Column | Notes |
|---|---|---|
| `name` | `name` | |
| `address` | `address` | |
| `city` | `city` | |
| `contact` | `phone` | |
| `image_url` | `image_path` | Download → local |

## Maharaj / Mataji (maharaj_mataji.json → *new table needed*)

| JSON Field | DB Column | Notes |
|---|---|---|
| `name` | `name` | |
| `details` | `description` | |
| `image_url` | `image_path` | |

## Yellow Pages (yellow_pages.json → com_business_listings)

| JSON Field | DB Column | Notes |
|---|---|---|
| `business_name` | `business_name` | |
| `category` | `category_name` / `category_id` | |
| `address` | `address` | |
| `contact_person` | `contact_person` | |
| `phone` | `phone` | |
| `email` | `email` | |

## Programs (programs_*.json → com_events)

| JSON Field | DB Column | Notes |
|---|---|---|
| `title` | `title` | |
| `date` | `event_date` | Parse DD/MM/YYYY |
| `venue` | `venue` | |
| `description` | `description` | |
| `image_url` | `banner_image` | |
| `type` | `event_type` | upcoming/recent/previous |

## News (news.json → com_news)

| JSON Field | DB Column | Notes |
|---|---|---|
| `title` | `title` | |
| `date` | `publish_date` | Parse DD/MM/YYYY |
| `description` | `content` | |
| `image_url` | `image` | |

## Gallery (gallery.json → *new table needed*)

| JSON Field | DB Column | Notes |
|---|---|---|
| `title` | `album_name` | |
| `thumbnail_url` | `thumbnail` | |
| `images[]` | Related table: `com_gallery_images` | |

## Static Pages (static_pages.json → com_pages)

| JSON Key | `slug` | Notes |
|---|---|---|
| `about` | `about` | Full HTML content |
| `history` | `history` | Full HTML content |
| `contact` | `contact` | Address, phone, email |
| `privacy_policy` | `privacy-policy` | |
| `terms` | `terms-conditions` | |
| `health_medical` | `health-medical` | |
| `education_scholarship` | `education-scholarship` | |
| `donation_pension` | `donation-pension` | |
