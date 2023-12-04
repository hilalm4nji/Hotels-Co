document.getElementById('feedbackForm').addEventListener('submit', function(event) {
  event.preventDefault();
  const name = document.getElementById('Name').value; //Get the value in the input of name
  const experience = document.querySelector('input[name="experience"]:checked'); //Get the checked radio of experience
  const checkBox = document.querySelectorAll('input[name="service"]:checked'); //Get the checked boxes of what costumer like
  const nameError = document.getElementById('nameError');
  if (!name.match(/\b\w+\s\w+\b/)) { //Checks if name is not will written, returns error
    nameError.style.display = 'block';
    nameError.textContent = 'Atleast two names are required. e.g. Ali Ahmed';
  } else { //if name is right returns nothing
    nameError.style.display = 'none';
  }

  const experienceError = document.getElementById('checkboxError');
  if (!experience) { //If nothing been chosen from radio return error
    experienceError.style.display = 'block';
    experienceError.textContent = "You didn't rate your experience";
  } else { //if there is radio checked return nothing
    experienceError.style.display = 'none';
  }

  const likesError = document.getElementById('radioError');
  if (checkBox.length < 2) { //if user choose less than two boxes return error
    likesError.style.display = 'block';
    likesError.textContent = 'Atleast select two things you like';
  } else { //if not return nothing
    likesError.style.display = 'none';
  }

  //if everything is fine display message that feedback has been sent
  if (name.match(/\b\w+\s\w+\b/) && experience && checkBox.length >= 2) {
    console.log('Your feedback help us a lot. Thanks for your time!');
  }
});
