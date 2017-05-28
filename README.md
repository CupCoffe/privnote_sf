Analogue of site Privnote.com
========================

Have you ever wanted to send confidential information within your work environment, to family or friends, but were afraid to do so 
over the internet, because some malicious hacker could be spying on you?

Privnote is a free web based service that allows you to send top secret 
notes over the internet. It's fast, easy, and requires no password or 
user registration at all.

How it works?
--------------

So here's what happens when you create a note in Privnote:

1. You write the note and click the POST button
2. The server generates a random note id, let's call it the NoteID. 
This is the 10 chars ID you see in the note link
3. The server hashes the note ID and gets a HashedNoteID = Hash(NoteID).
4. The server encrypts the note contents (and also the email and reference,
 if there is any) using the NoteID, and stores the encrypted version in 
 the database using the HashedNoteID as the database primary key.
 
 If someone with access to the database would like to read the note she would be 
 unable because she doesn't have the key to decrypt it (NoteID), only the 
 database primary key (HashedNoteID). The HashedNoteID cannot be used to
 "go back" to the NoteID because hashes are "one-way". So the only person
 who can actually decrypt (and thus see) the note is the one who has the
 original NoteID or, in other words, the one who has the link to the note.
 
 This is what happens when you view a note in Privnote:
 --------------
 * The server extracts the NoteID from the URL.
 * The server retrieves the note from the database using HashedNoteID as 
 the database primary key and decrypts its contents using NoteID as the 
 encryption key
 * The server shows the page with the decrypted note.
 