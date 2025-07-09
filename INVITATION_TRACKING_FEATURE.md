# Fitur Tracking Status Undangan

## Overview
Fitur ini menambahkan kemampuan untuk melacak status undangan dengan dua state baru:
- **Sent**: Status berubah otomatis ketika WhatsApp berhasil dikirim (baik individual maupun bulk)
- **Opened**: Status berubah otomatis ketika tamu membuka invitation letter

## Implementasi

### 1. Database Changes
- Ditambahkan 2 kolom baru di tabel `guests`:
  - `invitation_sent_at` (timestamp) - Kapan undangan dikirim via WhatsApp
  - `invitation_opened_at` (timestamp) - Kapan tamu membuka invitation letter

### 2. Status Flow
```
Not Set (-) → Sent → Opened
     ↓         ↓       ↓
   Manual   Auto    Auto
```

### 3. Controller Updates

#### GuestController
- `sendWhatsapp()`: Update status ke "Sent" dan set `invitation_sent_at` ketika WhatsApp berhasil dikirim
- `sendWhatsappBulk()`: Update status ke "Sent" dan set `invitation_sent_at` untuk setiap tamu yang berhasil
- Validation rules update untuk include status "Opened"

#### PublicInvitationController  
- `invitation_letter()`: Update status ke "Opened" dan set `invitation_opened_at` ketika tamu membuka undangan

### 4. Frontend Updates

#### DataTable
- Badge color untuk status "Opened" (badge-info)
- Tooltip untuk setiap status
- Auto refresh setelah send WhatsApp berhasil
- Clear selection setelah bulk send berhasil

#### Forms
- Edit form menampilkan timestamp sent_at dan opened_at (read-only)
- Show/detail view menampilkan tracking information
- Validation update untuk include "Opened" option

## Testing

### Test Individual WhatsApp Send
1. Login ke admin panel
2. Pilih invitation → Guests
3. Klik "Send WA" pada salah satu tamu
4. Pastikan status berubah menjadi "Sent"
5. Check detail tamu untuk melihat timestamp

### Test Bulk WhatsApp Send
1. Login ke admin panel
2. Pilih invitation → Guests
3. Select beberapa tamu dengan checkbox
4. Klik "Send Invitation via WA"
5. Pastikan status semua tamu berubah menjadi "Sent"

### Test Invitation Open Tracking
1. Ambil link undangan dari hasil WhatsApp
2. Buka link tersebut di browser
3. Kembali ke admin panel
4. Check status tamu - harus berubah menjadi "Opened"
5. Check detail tamu untuk melihat timestamp

## Features

### Status Badge Colors
- **Not Set (-)**: Gray (badge-secondary)
- **Pending**: Yellow (badge-warning)
- **Sent**: Green (badge-success)
- **Opened**: Blue (badge-info)

### Automatic Tracking
- ✅ Auto update ke "Sent" saat WhatsApp berhasil dikirim
- ✅ Auto update ke "Opened" saat invitation letter dibuka
- ✅ Timestamp logging untuk kedua events
- ✅ Read-only display di forms

### Manual Override
- Admin tetap bisa mengubah status secara manual melalui edit form
- Useful untuk kasus khusus atau koreksi data

## Database Schema

```sql
ALTER TABLE guests ADD COLUMN invitation_sent_at TIMESTAMP NULL AFTER guest_invitation_status;
ALTER TABLE guests ADD COLUMN invitation_opened_at TIMESTAMP NULL AFTER invitation_sent_at;
```

## Files Modified

### Controllers
- `app/Http/Controllers/GuestController.php`
- `app/Http/Controllers/PublicInvitationController.php`

### Models
- `app/Models/Guest.php`

### Views
- `resources/views/guests/index.blade.php`
- `resources/views/guests/edit_ajax.blade.php`
- `resources/views/guests/show_ajax.blade.php`
- `resources/views/guests/confirm_ajax.blade.php`

### Migrations
- `database/migrations/2025_07_09_153000_add_invitation_tracking_to_guests_table.php`

## Benefits

1. **Better Analytics**: Track engagement dengan undangan
2. **Automated Workflow**: Mengurangi manual tracking
3. **User Experience**: Visual feedback yang jelas untuk admin
4. **Data Integrity**: Timestamp yang akurat untuk audit trail
5. **Status Visibility**: Easy monitoring of invitation progress
