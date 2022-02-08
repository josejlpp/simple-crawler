<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>100 URLs most frequently accessed</title>
</head>
<body>
    <section class="container">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Short</th>
                <th scope="col">Title</th>
                <th scope="col">Access</th>
              </tr>
            </thead>
            <tbody>
            @forelse($moreAccess as $access)
              <tr>
                <td>{{ asset($access->short_url) }}</td>
                <td>{{ $access->title }}</td>
                <td>{{ $access->access_count }}</td>
              </tr>
            @empty
                <tr>
                    <td colspan="3">No url register!</td>
                </tr>
            @endforelse
            </tbody>
          </table>

    </section>
  <footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</footer>
</body>
</html>
