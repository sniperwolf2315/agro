console.log("REST_PIBOX_JS\n");

function API_REST_GET() {
  fetch(
    "https://sandbox.picap.co/api/third/bookings?t=De132wgUtgaH7c4DKwiz3VDo0MFwqHvzliztPvZW9W7TUTZn6JxatQ"
  )
    .then((response) => response.json())
    .then((json) => console.log(json))
    .catch((err) => console.log(err));
}

function API_REST_POST(URL) {
  fetch(
    "https://sandbox.picap.co/api/third/bookings/eta?t=De132wgUtgaH7c4DKwiz3VDo0MFwqHvzliztPvZW9W7TUTZn6JxatQ"
  )
    .then((response) => response.json())
    .then((json) => console.log(json))
    .catch((err) => {
      console.log(err);
    });
}

function API_REST_POST2(url_post, data_json) {
  console.log(data_json);
  
  // axios.post(url_post, {
  //     data_json
  //   })
  //   .then(function (response) {
  //     console.log(response);
  //   })
  //   .catch(function (error) {
  //     console.log(error);
  //   });
}




