<H2>A messenger application<H2> </br>
 </p><h6> Author: LinhDoan.</h6></p> </br>
Hiện nay ứng dụng web đã phát triển khác xa so với ngày đầu nó xuất hiện, kèm theo đó là vô số các kỹ thuật mới được áp dụng để phục vụ cho quá trình này nhằm đem lại trải nghiệm mới mẻ, đầy hứng thú và cũng không kém phần tiện dụng cho người dùng.

Để các bạn có 1 cái nhìn rõ ràng hơn về công nghệ web hiện đại, hôm nay mình sẽ giới thiệu với các bạn 1 số kỹ thuật hiện nay thường được sử dụng trong các ứng dụng web thời gian thực.

(Trong các ví dụ bên dưới, máy khách (client) sẽ là trình duyệt của người dùng, server sẽ là webserver hosting của website , bên trái là client và bên phải là server). Tuy nhiên trước tiên mình sẽ giới thiệu mô hình truy cập theo giao thức http truyền thống.

Regular HTTP:
Kỹ thuật lập trình web Regular HTTP

Người dùng gửi yêu cầu (request) 1 website từ một máy chủ.
Máy chủ (server) tính toán dữ liệu trả về ( response ).
Máy chủ gửi dữ liệu trả về (response) cho người dùng (client).
~> Client chủ động gửi request đến server thì sẽ có response trả về cho client, còn nếu ko có request từ client thì server sẽ không làm gì cả.

AJAX Polling:
Kỹ thuật lập trình web AJAX Polling

Client yêu cầu 1 trang web từ server sử dụng “Regular http” (đã nói ở trên).
Trang web mà client vừa yêu cầu sẽ dùng javascript thực hiện request liên tục đến 1 file trên server trong một khoảng thời gian đều đặn (ví dụ: cứ mỗi 2 giây sẽ gửi 1 request đến server).
Server sẽ tính toán response ứng với mỗi request và gửi lại response cho client giống như giao thức http truyền thống.
~> Client không chủ động gửi request đến server nhưng javascript của website vẫn luân phiên gửi request đến server và client sẽ nhận response từ server 1 cách bị động.

Tham khảo các khóa học lập trình online, onlab, và thực tập lập trình tại TechMaster
AJAX Long-Polling:
Kỹ thuật lập trình web AJAX Long-Polling

Client yêu cầu 1 trang web từ server sử dụng “Regular http” (đã nói ở trên).
Trang web mà client vừa yêu cầu sẽ dùng javascript thực hiện request đến 1 file trên server.
Server sẽ không gửi response ngay cho client (ứng với request đã gửi) mà sẽ đợi cho đến khi có dữ liệu mới.
Khi có dữ liệu mới, server sẽ gửi dữ liệu mới đó (response) về cho client.
Client sau khi nhận dữ liệu mới từ server, ngay lập tức sẽ tiếp tục 1 request khác đến server để bắt đầu lại toàn bộ tiến trình này (bước 3 đến 5).
~> Client sẽ gửi request đến server, server tiến hành kiếm tra dữ liệu và đến khi nào có dữ liệu mới thì mới gửi response về cho client. Sau đó client lại tiếp tục tự động gửi 1 request mới và đợi dữ liệu mới trả về.

HTML5 Server Sent Events (SSE) / Event Source:
Kỹ thuật lập trình web HTML5 Server Sent Events (SSE) / Event Source

Client yêu cầu 1 trang web từ server sử dụng “Regular http” (đã nói ở trên).
Trang web mà client vừa yêu cầu sẽ dùng javascript mở 1 kết nối đến server.
Kể từ lúc này server sẽ gửi response trả về cho client mỗi khi có dữ liệu mới.
~> Tức là client luôn nhận dữ liệu mới theo thời gian thực từ server chỉ với 1 lần request (dữ liệu 1 chiều từ server đến client). Lúc này trên server sẽ thực hiện 1 vòng lặp (loop) sự kiện (bước 1 đến 3) để thực hiện lại nhiều lần quy trình này, tuy nhiên bạn không thể kết nối đến server từ 1 tên miền (domain) khác.

HTML5 Websockets:
Kỹ thuật lập trình web HTML5 Websockets

Client yêu cầu 1 trang web từ server sử dụng “Regular http” (đã nói ở trên).
Trang web mà client vừa yêu cầu sẽ dùng javascript mở 1 kết nối đến server.
Bây giờ cả server và client có thể gửi nhận nhiều dữ liệu khác nhau với nhau khi có dữ liệu mới (giống như kiểu 2 bên đang chat với nhau chứ không phải tuân theo qui tắc nào).
~> Tức là client và server luôn nhận dữ liệu mới theo thời gian thực (2 chiều: server đến client hoặc client đến server). Lúc này trên server sẽ thực hiện 1 vòng lặp (loop) sự kiện (bước 1 đến 3) để thực hiện lại nhiều lần quy trình này và bạn có thể kết nối đến server từ 1 tên miền (domain) khác. Ngoài ra bạn cũng có thể sử dụng websocket server của bên thứ 3 cung cấp (ví dụ: http://pusher.com/) và việc còn lại là bạn chỉ việc code trên client ( dễ dàng hơn nhiều vì trước đó bạn phải code cả phía server và client).

Để dễ hiểu hơn, mình xin giải thích thêm cái hình ở trên, hình này minh họa nhiều trường hợp có thể xảy ra khi áp dụng web socket:

Trường hợp 1: tạo connect với server ~> nhận 2 response từ server.
Trường hợp 2: tạo connect với server ~> nhận 1 response từ server ~> client gửi tiếp 1 request khác đến server.
Trường hợp 3: tạo connect với server ~> nhận 2 response từ server ~> server trả về tiếp 1 reponse khác cho client (mặc dù không có request mới nào).
Comet:
Kỹ thuật lập trình web Comet

Comet là một thuật ngữ chung mô tả việc server gửi response dữ liệu cho client mà không cần 1 request rõ ràng. Ngoài ra nó còn được biết đến với những cái tên khác như: Ajax push, Reverse Ajax, Two-way-web, HTTP Streaming, HTTP server push. Trên thực tế ứng dụng comet có thể dùng 1 trong 2 kỹ thuật đó là: Streaming hoặc Long-Polling.

Comet có một sự ưu việt đó là request từ client đến server có thể được giữ trong 1 thời gian dài ( đến khi đạt giới hạn time-out ) để đợi response từ server trả về ( xem hình mô tả ở trên ), và sau đó sẽ tiếp tục gửi request mới để đợi response khác từ server.

Một ưu điểm lớn nữa của Comet đó là luôn có một liên kết giao tiếp giữa client và server, server có thể gửi response ngay khi request được gửi đến hoặc tích lũy response để gửi 1 lần. Nhưng vì các request tồn tại trong một thời gian dài ( long-lived request ) nên ở server cần một cơ chế đặc biệt để xử lý tất cả request loại này.

Kỹ thuật Long-Polling mình đã giới thiệu ở trên rồi nên không nhắc lại nữa, còn với streaming bạn có thể hiểu đơn giản thế này: hình thức nó giống với kỹ thuật long-polling nhưng khác là ta chỉ khởi tạo kết nối đến server một lần và gửi nhận dữ liệu thông qua kết nối này chứ không tạo kết nối mới. ( kỹ thuật streaming trên thực tế có thể được ứng dụng để làm web xem phim trực truyến, tải tới đâu coi tới đó và chỉ request đến file phim đúng 1 lần).
-~~~~ 
Với socket,Phân loại Socket
Stream Socket
Dựa trên giao thức TCP( Tranmission Control Protocol), stream socket thiết lập giao tiếp 2 chiều theo mô hình client và server. Được gọi là socket hướng kết nối.

TCP
Giao thức này đảm bảo dữ liệu được truyền đến nơi nhận một cách đáng tin cậy, đúng tuần tự nhờ vào cơ chế quản lý luồng lưu thông trên mạng và cơ chế chống tắc nghẽn.

Chúng cung cấp luồng dữ liệu không trùng lặp và có cơ chế được thiết lập tốt để tạo và hủy kết nối và phát hiện lỗi. Nếu việc gửi các gói dữ liệu là không thể, người gửi sẽ nhận được một chỉ báo lỗi.

Đặc điểm tóm gọn:

Có một đường kết nối (địa chỉ IP) giữa 2 tiến trình.
Một trong hai tiến trình kia phải đợi tiến trình này yêu cầu kết nối.
Mô hình client /sever thì sever lắng nghe và chấp nhận từ client.
Mỗi thông điệp gửi phải có xác nhận trả về.
Các gói tin chuyển đi tuần tự.
 Datagram Socket
Dựa trên giao thức UDP( User Datagram Protocol) việc truyền dữ liệu không yêu cầu có sự thiết lập kết nối giữa 2 process. Tức là nó cung cấp connection-less point cho việc gửi và nhận packets. Gọi là socket không hướng kết nối

UDP
Do không yêu cầu thiết lập kết nối, không phải có những cơ chế phức tạp. Nên tốc độ giao thức khá nhanh, thuận tiện cho các ứng dụng truyền dữ liệu nhanh như chat, game online…

Đặc điểm tóm gọn:

Hai tiến trình liên lạc với nhau không kết nối trực tiếp
Thông điệp gửi đi phải kèm theo thông điệp người nhận
Thông điệp có thể gửi nhiều lần
Người gửi không chắc chắn thông điệp đến tay người nhận.
Thông điệp gửi sau có thể đến trước và ngược lại.
Để có thể thực hiện các cuộc giao tiếp, một trong 2 quá trình phải công bố port của socket mà mình đang sử dụng.
Websocket là gì?
Websocket là giao thức hỗ trợ giao tiếp hai chiều giữa client và server để tạo một kết nối trao đổi dữ liệu. Giao thức này không sử dụng HTTP mà thực hiện nó qua TCP. Mặc dù được thiết kế để chuyên sử dụng cho các ứng dụng web, lập trình viên vẫn có thể đưa chúng vào bất kì loại ứng dụng nào.

Ưu điểm
WebSocket cung cấp giao thức giao tiếp hai chiều mạnh mẽ. No có độ trễ thấp và dễ xử lý lỗi. Websocket thường được sử dụng cho những trường hợp yêu cầu real time như chat, hiển thị biểu đồ hay thông tin chứng khoán.

Các gói tin (packets) của Websocket nhẹ hơn HTTP rất nhiều. Nó giúp giảm độ trễ của network nhiều lần.
https://topdev.vn/blog/socket-la-gi-websocket-la-gi/
https://techmaster.vn/posts/33693/ky-thuat-long-polling-websockets-server-sent-events-comet
