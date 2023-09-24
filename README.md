# MP3 To Spotify
I've had lots of songs from the past in MP3 format and now that I've moved to Spotify, I needed all the MP3 files on Spotify (not as local files but actual Spotify tracks). And no way I'm adding them to my playlist one by one, there's alot of them. So I wrote a script! I've been able to transfer about 1000+ songs with just a few failures (only because Spotify doesn't have those songs).

# Features
1. Supports transfers from text files with names of artists/tracks
2. Supports transfers from folders containing MP3 files
3. Interactive and pretty looking terminal UI
4. Logs transfer progress and failed transfers
5. Provides `.env` file to pre-configure variables so you can skip the input in terminal UI

# How It Works?
1. **Create an app** on Spotify Developer Dashboard to obtain client ID and client secret
2. The program asks the user to **authorize** the app to find and add tracks to their playlists
3. Once authorized, the app requests Spotify for an **access token** to update the playlists on the user's behalf
4. After all the inputs (path to local tracks, name separator) have been gathered, the transfer process starts
5. All the local tracks are searched on Spotify and their URIs are stored in memory
6. The selected playlist is updated with the URIs from the previous step in batch

# Setup
1. Clone the repository on to your machine and open the directory on your terminal.
2. Start a local PHP server. This will be used for authorization callback. Run the following command in terminal:
    ```bash
    $ php -S 127.0.0.1:9001
    ```
3. *(Optional)* Duplicate the `.env.sample` file and rename it to `.env`. Update the necessary values.
    - Note that, if the `.env` file is not provided, the user will be asked to enter necessary information. The `redirect uri` however will be defaulted to `http://localhost:9001`
4. You're all set! Run this command to start the process:
    ```bash
    $ php src/Transfer.php
    ```
5. *(Info)* You can view the logs under the `logs` folder
    - In case success and if the song couldn't be found on Spotify, it'll reflect in `transfer.log`
    - In case failures, due to incorrect naming convention, it'll reflect in `failed.log`
6. *(Bonus)* If you want to retry the failed transfer:
    - Copy the failed tracks to a new `.txt` file
    - Fix the naming convention
    - Start the transfer process again but with path set to the newly created `.txt`` file

## Supported Platforms
1. MacOS
2. Linux
3. WSL on Windows

# Credits
- 3rd Party API usage abstraction inspiration taken from [Nuno Maduro's](https://twitter.com/enunomaduro) [openai/client](https://github.com/openai-php/client)
- (Simple Quick Logger)[https://github.com/Idearia/php-logger/blob/master/src/Logger.php]