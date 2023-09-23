# MP3 To Spotify
I've had lots of songs from the past in MP3 format and now that I've moved to Spotify, I needed all the MP3 files on Spotify (not as local files but actual Spotify tracks). And no way I'm adding them to my playlist one by one, there's alot of them. So I wrote a script!

## Supported Platforms
1. MacOS
2. Linux
3. WSL on Windows

# Flow
1. In command line, call: `php convert.php`
2. Authorize Spotify
3. Select Spotify Playlist to add to
4. Set folder path to find MP3s
5. Set delimiter for artist/track name
6. Select which side is artist and which is track name
7. Loop through each MP3 file, get the track ID. Log the ones that are not found. Also, show progress in command line
8. Once done, add to selected playlist in batches
9. Done!