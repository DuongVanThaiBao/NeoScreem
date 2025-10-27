<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>In báo cáo chấm công</title>
  <style>
    body{ font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; color:#111827; }
    h1{ font-size:20px; margin:0 0 8px; }
    .meta{ color:#6b7280; font-size:12px; margin-bottom:12px; }
    table{ border-collapse: collapse; width:100%; font-size:12px; }
    th, td{ border:1px solid #e5e7eb; padding:6px 8px; text-align:left; }
    th{ background:#f3f4f6; }
    .wrap{ max-width:960px; margin:24px auto; }
    @media print{ .no-print{ display:none; } body{ color:#000; } }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="no-print" style="margin-bottom:12px;">
      <button onclick="window.print()">In</button>
    </div>
    <h1>Báo cáo chấm công</h1>
    <div class="meta">
      Khoảng thời gian: {{ isset($range[0]) ? $range[0]->format('d/m/Y') : '' }} - {{ isset($range[1]) ? $range[1]->format('d/m/Y') : '' }}
    </div>
    <table>
      <thead>
        <tr>
          <th>Nhân viên</th>
          <th>Bộ phận</th>
          <th>Ngày</th>
          <th>Bắt đầu</th>
          <th>Kết thúc</th>
          <th>Giờ làm</th>
          <th>Trạng thái</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rows as $r)
          <tr>
            <td>{{ optional($r->employee)->name }}</td>
            <td>{{ $r->department ?: optional($r->employee)->department }}</td>
            <td>{{ \Carbon\Carbon::parse($r->date)->format('d/m/Y') }}</td>
            <td>{{ substr($r->start_time,0,5) }}</td>
            <td>{{ substr($r->end_time,0,5) }}</td>
            <td>
              @php
                try{ $s=\Carbon\Carbon::createFromFormat('H:i:s',$r->start_time); $e=\Carbon\Carbon::createFromFormat('H:i:s',$r->end_time); $h=max(0,$e->floatDiffInHours($s)); }
                catch(\Throwable $e){ $h=0; }
              @endphp
              {{ number_format($h,1) }}
            </td>
            <td>{{ $r->status }}</td>
          </tr>
        @empty
          <tr><td colspan="7" style="text-align:center; color:#6b7280;">Không có dữ liệu</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <script>window.addEventListener('load', function(){ setTimeout(function(){ window.print(); }, 100); });</script>
</body>
</html>
