/**=====================
    Sweet-alert Start
==========================**/
var SweetAlert_custom = {
  init: function () {
    (document.querySelector(".sweet-1").onclick = function () {
      swal({
        title: "Welcome! to the cuba theme",
      });
    }),
      (document.querySelector(".sweet-2").onclick = function () {
        swal("It's Magic!", "Thank you for visiting cuba theme");
      }),
      (document.querySelector(".sweet-4").onclick = function () {
        swal("Please Click on this button it's big surprise for you.").then(
          (value) => {
            swal(`Thank you for visit cuba theme: ${value}`);
          }
        );
      }),
      (document.querySelector(".sweet-5").onclick = function () {
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this imaginary file!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
            swal("Poof! Your imaginary file has been deleted!", {
              icon: "success",
            });
          } else {
            swal("Your imaginary file is safe!");
          }
        });
      }),
      (document.querySelector(".sweet-6").onclick = function () {
        swal("Good job!", "You clicked the button!", "warning");
      }),
      (document.querySelector(".sweet-7").onclick = function () {
        swal("It's danger", "Something went wrong!", "error");
      }),
      (document.querySelector(".sweet-8").onclick = function () {
        swal("Good job!", "You clicked the button!", "success");
      }),
      (document.querySelector(".sweet-11").onclick = function () {
        swal("Are you sure you want to do this?", {
          buttons: ["Oh noez!", "Aww yiss!"],
        });
      }),
      (document.querySelector(".sweet-12").onclick = function () {
        swal("A wild Pikachu appeared! What do you want to do?", {
          buttons: {
            cancel: "Run away!",
            catch: {
              text: "Throw Pokeball!",
              value: "catch",
            },
            defeat: true,
          },
        }).then((value) => {
          switch (value) {
            case "defeat":
              swal("Pikachu fainted! You gained 500 XP!");
              break;
            case "catch":
              swal("Yeah!", "Pikachu was caught!", "success");
              break;
            default:
              swal("Got away safely!");
          }
        });
      }),
      (document.querySelector(".sweet-13").onclick = function () {
        swal("Please! Submit Your Username :", {
          content: "input",
        }).then((value) => {
          swal(`Your name is : ${value}`);
        });
      });
    document.querySelector(".sweet-14").onclick = function () {
      swal("Auto close alert!", "just a wait!  I will close in 30 second!", {
        buttons: false,
        timer: 4000,
        className: "alert-light-dark",
      });
    };
    document.querySelector(".sweet-15").onclick = function () {
      swal({
        text: 'Search for a movie. e.g. "Herry Poter".',
        content: "input",
        button: {
          text: "Search!",
          closeModal: false,
        },
      })
        .then((name) => {
          if (!name) throw null;

          return fetch(
            `https://itunes.apple.com/search?term=${name}&entity=movie`
          );
        })
        .then((results) => {
          return results.json();
        })
        .then((json) => {
          const movie = json.results[0];

          if (!movie) {
            return swal("No movie was found!");
          }

          const name = movie.trackName;
          const imageURL = movie.artworkUrl100;

          swal({
            title: "Top result:",
            text: name,
            icon: imageURL,
          });
        })
        .catch((err) => {
          if (err) {
            swal("Oh noes!", "The AJAX request failed!", "error");
          } else {
            swal.stopLoading();
            swal.close();
          }
        });
    };
  },
};
(function ($) {
  SweetAlert_custom.init();
})(jQuery);

/**=====================
  Sweet-alert Ends
==========================**/
