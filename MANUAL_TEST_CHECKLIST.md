# 📋 MANUAL TESTING CHECKLIST - Sistem Manajemen Perpustakaan Digital

**Tanggal:** 16 Maret 2026  
**Status:** Database Seeded ✅  
**Total Test Cases:** 45

---

## 🔑 Test Credentials

### Admin Account
- **Email:** admin@library.com
- **Password:** Admin123!
- **Role:** Administrator

### Member Accounts (Use any)
- budi@example.com / Password123
- siti@example.com / Password123
- andi@example.com / Password123
- rini@example.com / Password123
- hendra@example.com / Password123

---

## 📊 Seeded Data Summary

| Komponen | Jumlah | Status |
|----------|--------|--------|
| Admin User | 1 | ✅ admin@library.com |
| Member Users | 5 | ✅ Budi, Siti, Andi, Rini, Hendra |
| Categories | 3 | ✅ Fiksi, Non-Fiksi, Sains & Teknologi |
| Books | 10 | ✅ Distributed across 3 categories |
| Borrowings | 5 | ✅ Mixed statuses (borrowed, returned, overdue) |

---

## 🧪 TEST GROUP 1: AUTHENTICATION

### ✅ Test 1.1 - Admin Login
- [ ] Navigate to `/login`
- [ ] Enter: admin@library.com / Admin123!
- [ ] Click "Masuk"
- **Expected:** Redirect to dashboard with "Welcome Admin Library" message

### ✅ Test 1.2 - Member Login
- [ ] Navigate to `/login`
- [ ] Enter: budi@example.com / Password123
- [ ] Click "Masuk"
- **Expected:** Redirect to member dashboard with user profile

### ✅ Test 1.3 - Invalid Credentials
- [ ] Login with wrong password
- **Expected:** Error message "Email atau password salah"

### ✅ Test 1.4 - Registration
- [ ] Click "Daftar" on login page
- [ ] Fill form:
  - Nama: Test User
  - Email: test@example.com
  - Telepon: 08123456789
  - Alamat: Jl Test
  - Password: Test12345
  - Konfirmasi: Test12345
- [ ] Submit
- **Expected:** Auto-login to new member account, redirect to dashboard

### ✅ Test 1.5 - Logout
- [ ] Click "Logout" in navbar
- **Expected:** Redirect to login page, session destroyed

---

## 🎯 TEST GROUP 2: BOOKS - LISTING & SEARCH

### ✅ Test 2.1 - Books List (Member View)
- [ ] Login as member
- [ ] Navigate to "Books" or `/books`
- **Expected:**
  - Table with 10 books visible
  - Columns: Judul, Kategori, ISBN, Stok, Status, Aksi
  - Pagination showing 12 items per page

### ✅ Test 2.2 - Stock Status Badge
- [ ] Verify book with stock > 0 shows "Tersedia" (green badge)
- **Expected:**
  - Laskar Pelangi (5 stok): Green "Tersedia"
  - Semua buku non-zero: Green badge

### ✅ Test 2.3 - Search by Title
- [ ] Type "Laskar" in search box
- [ ] Click "Cari"
- **Expected:**
  - Only "Laskar Pelangi" book shown
  - Other books filtered out

### ✅ Test 2.4 - Search by Author
- [ ] Clear search, type "Andrea Hirata"
- [ ] Click "Cari"
- **Expected:**
  - 2 books shown (Laskar Pelangi, Sang Pemimpi)

### ✅ Test 2.5 - Filter by Category
- [ ] Select category "Fiksi" from dropdown
- [ ] Click "Cari"
- **Expected:**
  - Only 4 fiction books displayed

### ✅ Test 2.6 - Sort by Newest
- [ ] Select "Terbaru" from sort dropdown
- [ ] Click "Cari"
- **Expected:**
  - Books sorted by created_at DESC

### ✅ Test 2.7 - Sort by Most Borrowed
- [ ] Select "Paling Sering Dipinjam" from sort
- [ ] Click "Cari"
- **Expected:**
  - Books with more borrowings appear first

### ✅ Test 2.8 - Reset Filter
- [ ] Apply search/filter
- [ ] Click "Reset"
- **Expected:**
  - All 10 books shown again
  - Search box cleared

---

## 📖 TEST GROUP 3: BOOKS - DETAILS

### ✅ Test 3.1 - View Book Details (Member)
- [ ] Click on any book title or "Lihat Detail"
- **Expected:**
  - Book cover or placeholder icon
  - Title, Author, Category, ISBN, Publisher, Year
  - Description, Status badge
  - 3 stat cards: Total Peminjaman, Sudah Dikembalikan, Sedang Dipinjam
  - If stok > 0: "Pinjam Buku Ini" button (blue)

### ✅ Test 3.2 - Book Status on Detail Page
- [ ] Check "Status" card
- **Expected:**
  - If stock > 0: Green "Tersedia" badge
  - If stock = 0: Red "Habis Terjual" badge

### ✅ Test 3.3 - Borrow Button Visibility
- [ ] View book with stock > 0
- [ ] Member sees "Pinjam Buku Ini" button
- **Expected:**
  - Button is blue and clickable
  - Button links to borrow/create flow (or shows quick borrow option)

### ✅ Test 3.4 - View Book Details (Admin)
- [ ] Login as admin, navigate to `/books`
- [ ] Click book title
- **Expected:**
  - Same as member view PLUS:
  - "Edit Buku" button (green)
  - "Hapus Buku" button (red)
  - Borrowing history table below

---

## ➕ TEST GROUP 4: BOOKS - CREATE & EDIT (ADMIN ONLY)

### ✅ Test 4.1 - Member Cannot Access Create
- [ ] Login as member
- [ ] Try accessing `/books/create` directly
- **Expected:**
  - Access denied or redirect to dashboard
  - No "Tambah Buku" button visible in books list

### ✅ Test 4.2 - Admin Can See Create Button
- [ ] Login as admin
- [ ] Navigate to `/books`
- **Expected:**
  - "Tambah Buku" button visible in header (blue)

### ✅ Test 4.3 - Create Book Form
- [ ] Click "Tambah Buku"
- [ ] Fill form:
  - Judul: Test Book Title
  - Penulis: Test Author
  - ISBN: 123-456-789-TEST
  - Kategori: Fiksi
  - Penerbit: Test Publisher
  - Tahun Terbit: 2024
  - Stok: 5
  - Deskripsi: This is a test book
  - Cover: Upload or skip
- [ ] Click "Simpan Buku"
- **Expected:**
  - Redirect to books list
  - Success message: "Buku berhasil ditambahkan"
  - New book appears in list

### ✅ Test 4.4 - Create Book Validation
- [ ] Click "Tambah Buku"
- [ ] Submit empty form
- **Expected:**
  - Red error messages appear:
    - "Judul buku harus diisi"
    - "Nama penulis harus diisi"
    - etc. for all required fields

### ✅ Test 4.5 - Unique ISBN Validation
- [ ] Try creating book with existing ISBN
- **Expected:**
  - Error: "ISBN sudah terdaftar di sistem"

### ✅ Test 4.6 - Edit Book
- [ ] Click "Edit" button on book (green icon)
- [ ] Change title to "Modified Title"
- [ ] Change stock to 8
- [ ] Click "Perbarui Buku"
- **Expected:**
  - Redirect to book detail page
  - Success message: "Buku berhasil diperbarui"
  - Changes reflected in list

### ✅ Test 4.7 - Edit Book Validation
- [ ] Edit book, clear "Judul" field
- [ ] Submit
- **Expected:**
  - Error: "Judul buku harus diisi"

### ✅ Test 4.8 - Delete Book (No Active Borrowing)
- [ ] Create a new test book (no one borrowed it)
- [ ] Click delete button (red trash icon)
- [ ] Confirm deletion
- **Expected:**
  - Book removed from list
  - Success message: "Buku berhasil dihapus"

### ✅ Test 4.9 - Cannot Delete Book With Active Borrowing
- [ ] Try to delete "Laskar Pelangi" (has active borrowings)
- [ ] Click delete button
- **Expected:**
  - Error message: "Buku tidak dapat dihapus karena masih sedang dipinjam"
  - Book remains in list

---

## 📚 TEST GROUP 5: BORROWINGS - LISTING

### ✅ Test 5.1 - Admin View All Borrowings
- [ ] Login as admin
- [ ] Navigate to `/borrowings`
- **Expected:**
  - Table with ALL 5 borrowings (admin@library.com shouldn't have personal borrowings shown)
  - Columns: Anggota, Buku, Tanggal Peminjaman, Jatuh Tempo, Status, Denda, Aksi

### ✅ Test 5.2 - Member View Only Own Borrowings
- [ ] Login as Budi
- [ ] Navigate to `/borrowings`
- **Expected:**
  - Table shows only Budi's borrowings
  - Does NOT show other members' borrowings

### ✅ Test 5.3 - Status Badge Colors
- [ ] Verify status badges in borrowing table:
  - **Blue** "⏳ Dipinjam": Books still being borrowed
  - **Green** "✓ Dikembalikan": Returned books
  - **Red** "⚠ Terlambat": Overdue books
- **Expected:**
  - Borrowed: 2 entries (blue)
  - Returned: 2 entries (green)
  - Overdue: 1 entry (red)

### ✅ Test 5.4 - Overdue Indicator
- [ ] Check overdue borrowing row
- **Expected:**
  - Red text: "6 hari terlambat" in due date column

### ✅ Test 5.5 - Member Count (Admin)
- [ ] Admin navigates to borrowings list
- [ ] Verifies Anggota column shows:
  - Budi Santoso (budi@example.com)
  - Siti Nurhaliza (siti@example.com)
  - etc.

### ✅ Test 5.6 - Pagination
- [ ] With 5 borrowings, verify pagination
- **Expected:**
  - 15 items per page
  - All 5 shown on page 1
  - Only 1 page needed

---

## 🔄 TEST GROUP 6: BORROWINGS - CREATE & PROCESS RETURN

### ✅ Test 6.1 - Member Can Borrow Book
- [ ] Login as member Siti
- [ ] Navigate to `/borrowings/create` or click "Pinjam Buku"
- **Expected:**
  - Grid of books with stock > 0
  - Each book shows category, title, author, year, publisher
  - Green stock badge
  - "Pinjam" button visible

### ✅ Test 6.2 - Click Pinjam Button
- [ ] Click "Pinjam" on "Negeri 5 Menara"
- **Expected:**
  - Redirect to borrowing detail page
  - Success message: "Buku berhasil dipinjam. Tenggat waktu pengembalian: [date]"
  - Status shows "Dipinjam"
  - Due date is 14 days from now

### ✅ Test 6.3 - Book Stock Decreases After Borrow
- [ ] Navigate back to `/books/show` for borrowed book
- [ ] Check stock decremented by 1
- **Expected:**
  - If was 4 stok, now shows 3 stok
  - Status badge still "Tersedia" (if remaining > 0)

### ✅ Test 6.4 - Cannot Borrow Same Book Twice
- [ ] User already borrowed "Laskar Pelangi"
- [ ] Try to borrow "Laskar Pelangi" again
- **Expected:**
  - Error message: "Anda sudah meminjam buku ini dan belum mengembalikannya"

### ✅ Test 6.5 - Cannot Borrow Out of Stock
- [ ] Manually reduce book stock to 0
- [ ] Try to borrow that book
- **Expected:**
  - Book not shown in available books grid
  - Error if trying direct route: "Buku tidak tersedia untuk dipinjam"

### ✅ Test 6.6 - Admin Create Borrow for Member
- [ ] Login as admin
- [ ] Navigate to `/borrowings/create`
- **Expected:**
  - Dropdown shows: "Untuk Diri Sendiri" PLUS list of all 5 members
  - Can select member name + email

### ✅ Test 6.7 - Admin Select Member & Borrow
- [ ] Select "Rini Handayani" from dropdown
- [ ] Click "Filter" (if needed) or directly select book
- [ ] Click "Pinjam"
- **Expected:**
  - Borrowing created for Rini (not admin)
  - Success message shown
  - Detail page shows Rini as borrower

### ✅ Test 6.8 - View Borrowing Detail (Member)
- [ ] Member clicks on borrowing
- **Expected:**
  - Left: Book cover + Status card
  - Status: "Sedang Dipinjam"
  - Right: Book info, Member info
  - Duration card: Days remaining
  - Fine card: "Rp 0" (not overdue)
  - "Kembalikan Buku" button (green)

### ✅ Test 6.9 - Return Book (Tepat Waktu)
- [ ] Member clicks "Kembalikan Buku"
- [ ] For on-time return:
- **Expected:**
  - Status changes to "Dikembalikan"
  - Return date shows current date
  - Fine: "Rp 0"
  - Book stock incremented +1
  - Success message

### ✅ Test 6.10 - Fine Calculation (Overdue)
- [ ] Check overdue borrowing detail (6 days late)
- **Expected:**
  - Fine card shows: "Rp 6.000" (6 × Rp 1.000)
  - Status badge red "Terlambat"
  - Days displayed: "6 hari terlambat"

### ✅ Test 6.11 - Return Overdue Book
- [ ] Overdue borrower clicks "Kembalikan Buku"
- **Expected:**
  - Status changes to "Dikembalikan"
  - Fine amount pre-calculated: "Rp 6.000"
  - User informed of fine amount in message
  - Success message includes fine info

---

## 👩‍💼 TEST GROUP 7: DASHBOARD - ADMIN

### ✅ Test 7.1 - Admin Dashboard Access
- [ ] Login as admin
- [ ] Navigate to `/dashboard`
- **Expected:**
  - Admin-specific dashboard layout
  - 4 stat cards visible

### ✅ Test 7.2 - Stat Card 1: Total Buku
- [ ] Admin dashboard, first card (blue border)
- **Expected:**
  - Title: "Total Buku"
  - Count: 10 (minus any deleted in tests)

### ✅ Test 7.3 - Stat Card 2: Total Anggota
- [ ] Admin dashboard, second card (green border)
- **Expected:**
  - Title: "Total Anggota"
  - Count: 5 (members only, not admin)

### ✅ Test 7.4 - Stat Card 3: Active Borrowings
- [ ] Admin dashboard, third card (purple border)
- **Expected:**
  - Count: 2 (borrowed + overdue not returned)

### ✅ Test 7.5 - Stat Card 4: Overdue Books
- [ ] Admin dashboard, fourth card (red border)
- **Expected:**
  - Count: 1 (one overdue borrowing)

### ✅ Test 7.6 - Recent Borrowings Table
- [ ] Admin dashboard, "Peminjaman Terbaru" section
- **Expected:**
  - 10 most recent borrowings (or up to 10)
  - Columns with member name, book, dates, status
  - Status badges color-coded

### ✅ Test 7.7 - Overdue Borrowings Table
- [ ] Admin dashboard, "Peminjaman Terlambat" section
- **Expected:**
  - Shows overdue borrowings
  - Includes: Member, Book, Due date, Days late, Fine amount

---

## 👤 TEST GROUP 8: DASHBOARD - MEMBER

### ✅ Test 8.1 - Member Dashboard Access
- [ ] Login as member Budi
- [ ] Navigate to `/dashboard`
- **Expected:**
  - Member-specific dashboard layout
  - User profile card with gradient

### ✅ Test 8.2 - Profile Card Info
- [ ] Member dashboard
- **Expected:**
  - Name: "Budi Santoso"
  - Email: "budi@example.com"
  - Phone: "08111111111"
  - Join date shown
  - Member ID shown

### ✅ Test 8.3 - Member Stat Card 1: Active Borrowings
- [ ] First blue card
- **Expected:**
  - Shows number of currently borrowed books

### ✅ Test 8.4 - Member Stat Card 2: Returned Books
- [ ] Second green card
- **Expected:**
  - Shows number of returned books

### ✅ Test 8.5 - Member Stat Card 3: Total Fine
- [ ] Third red card
- **Expected:**
  - Shows sum of all fines
  - Format: "Rp X.XXX"

### ✅ Test 8.6 - Quick Actions
- [ ] "Browse Books" button
- [ ] "Borrow New Book" button
- **Expected:**
  - Both link to appropriate pages

### ✅ Test 8.7 - Borrowing History
- [ ] Member dashboard, borrowing history section
- **Expected:**
  - List of member's borrowings (up to 10)
  - Book title + author
  - Category
  - Dates
  - Status badge
  - View detail link

---

## 🔐 TEST GROUP 9: AUTHORIZATION & SECURITY

### ✅ Test 9.1 - Member Cannot Access Admin Routes
- [ ] Login as member
- [ ] Try accessing `/books/create` directly
- **Expected:**
  - Redirect or access denied
  - No admin-only operations allowed

### ✅ Test 9.2 - Admin Middleware Works
- [ ] Not logged in, try `/books/create`
- **Expected:**
  - Redirect to login page

### ✅ Test 9.3 - Member Sees Own Borrowings Only
- [ ] Member Budi logs in
- [ ] Navigate to `/borrowings`
- **Expected:**
  - Only shows Budi's borrowings
  - Others' borrowings hidden

### ✅ Test 9.4 - Member Cannot Delete Borrowings
- [ ] Member clicks on borrowing
- **Expected:**
  - No delete button visible
  - Only delete button (red trash) for admin

### ✅ Test 9.5 - Password Hashing
- [ ] Admin can login with "Admin123!"
- [ ] Database check: password != plain text
- **Expected:**
  - Password stored as hash in DB
  - Cannot see plain password in database

---

## 📲 TEST GROUP 10: RESPONSIVE DESIGN

### ✅ Test 10.1 - Mobile View (320px)
- [ ] Browser resize to 320px width
- [ ] Navigate to `/books`
- **Expected:**
  - Table scrollable horizontally
  - All content readable
  - No overlapping text

### ✅ Test 10.2 - Tablet View (768px)
- [ ] Resize to 768px
- [ ] Navigate to `/dashboard`
- **Expected:**
  - 2-column layout where applicable
  - Stat cards stack nicely
  - Sidebar visible on lg breakpoint

### ✅ Test 10.3 - Navbar on Mobile
- [ ] On mobile, click hamburger menu
- **Expected:**
  - Mobile nav toggles
  - Menu items visible
  - Overlay closes on item click

### ✅ Test 10.4 - Form Responsive
- [ ] Open book create form on mobile
- **Expected:**
  - Single column layout
  - All fields fully accessible
  - Labels visible

---

## ✨ TEST GROUP 11: UI/UX VALIDATION

### ✅ Test 11.1 - Color Consistency
- [ ] Verify navbar color: Blue-900 (#1e3a8a)
- [ ] Verify sidebar: Blue-800 (#1e40af)
- **Expected:**
  - Consistent blue theme across app

### ✅ Test 11.2 - Icon Consistency
- [ ] Verify Font Awesome icons loaded
- [ ] Check all icons display correctly
- **Expected:**
  - No broken icon references

### ✅ Test 11.3 - Flash Messages Display
- [ ] Create a book or borrow book
- **Expected:**
  - Success message displays with:
    - Green background + icon
    - Auto-hide after 5-10 seconds
    - Or manual close button

### ✅ Test 11.4 - Error Messages Display
- [ ] Trigger validation error
- **Expected:**
  - Red background + icon
  - Clear error message
  - Field highlighted

### ✅ Test 11.5 - Empty State Message
- [ ] Filter books with no results
- **Expected:**
  - Centered icon + message
  - "Tidak ada data buku yang ditemukan"
  - Suggestion to change filters

---

## 🔄 TEST GROUP 12: DATA INTEGRITY

### ✅ Test 12.1 - Stock Never Negative
- [ ] Book with 1 stok, borrow it
- [ ] Verify stock is now 0
- **Expected:**
  - Stock: 0 (not negative)
  - Cannot borrow (no button or error)

### ✅ Test 12.2 - Soft Delete Test
- [ ] Delete admin-created test book
- [ ] Check database directly or try to access via URL
- **Expected:**
  - Book removed from UI
  - (Soft delete if implemented, harder delete acceptable for demo)

### ✅ Test 12.3 - Relationship Integrity
- [ ] Create borrowing, delete user
- **Expected:**
  - Cascade or restrict based on DB constraints
  - No orphaned records

### ✅ Test 12.4 - Unique ISBN Enforced
- [ ] Try creating 2 books with same ISBN
- **Expected:**
  - Either validation error or DB error
  - Cannot create duplicate ISBN

---

## 📊 FINAL VERIFICATION CHECKLIST

- [ ] All 10 books visible in list
- [ ] All 5 borrowings show correct status
- [ ] Admin account works: admin@library.com / Admin123!
- [ ] All 5 member accounts functional
- [ ] Stock management accurate
- [ ] Fine calculation correct (Rp 1.000/day)
- [ ] Dashboard stats accurate
- [ ] No database errors in console
- [ ] No JavaScript errors in browser console
- [ ] All buttons are clickable and functional
- [ ] All forms validate properly
- [ ] Responsive design works on mobile
- [ ] Authorization working (member/admin separation)
- [ ] Flash messages display correctly
- [ ] Search and filter functionality working
- [ ] Status badges displaying correct colors

---

## 📝 NOTES FOR TESTING

1. **Clear Browser Cache** before starting tests if you've tested before
2. **Check Browser Console** (F12) for any JavaScript errors
3. **Check Network Tab** for any failed HTTP requests
4. **Test on Different Browsers** if possible (Chrome, Firefox, Safari)
5. **Take Screenshots** of key features for documentation
6. **Document Any Issues** with screenshot + description
7. **Verify Datetime Formats** are in Indonesian locale
8. **Check Email Format** validation accepts valid emails only

---

## 🎉 SUCCESS CRITERIA

**Minimum Passing Score:** 40/45 tests passed

**If All Tests Pass:**
✅ System is ready for production use!

**If <40 Tests Pass:**
⚠️ Review failed tests and fix issues before production

---

**Test Performed By:** ________________  
**Date:** ________________  
**Overall Result:** ☐ PASS ☐ FAIL  
**Notes:** ___________________________________________
