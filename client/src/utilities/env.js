
let base = "http://img-env.us-east-2.elasticbeanstalk.com/";
let Env = {
   api : base,
   gallery : base + "gallery.php",  // get the front page gallery, public.
   upload : base + "upload.php",    // post a photo, private.
   login: base + "login.php",       // post login credentials, public.
   upvote: base + "upvote.php",     // post an upvote, private.
   downvote: base + "downvote.php", // post a downvote, private.
   view: base + "views.php",        // post a view, public.
   profile: base + "profile.php",   // post a profile update, private.
   username: base +"username.php",  // post a username, public.
   register: base + "register.php", // post a signup form, public.
   account: base+ "account.php",    // get a user profile, public.
   album: base + "album.php",       // get a user's uploads, private.
   admin: base + "admin.php",       // get admin panel content, private.
};

export default Env;