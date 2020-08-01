<div class="col-sm-12 col-lg-4">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Top Referrals</h4>
        <table class="table v-middle">
          <thead>
            <tr>
              <th class="border-top-0">Users</th>
              <th class="text-center border-top-0">Total-Referrals</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($referrers as $key)
              @if ($key["count"] > 0)
                <tr>
                  <td class="font-bold">{{ $key["user"]->name }}</td>
                  <td class="text-center">{{ $key["count"] }}</td>
                </tr>
              @endif
            @endforeach
          

          </tbody>
        </table>
      </div>
    </div>
  </div>