<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		#canvas {
			width: 100%;
			height: 80%;
		}
	</style>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script>
		var over = 0;
	</script>
	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- Scripts -->
	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body onload='canv();' onresize='canv();'>
	<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
		<div class="container">
			@auth
				@if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin() )
					<li style="padding-right: 30px;" class="nav-item">
						<a class="nav-link" href="{{ route('users.index') }}">Users</a>
					</li>
					<li style="padding-right: 30px;" class="nav-item">
						<a class="nav-link" href="{{ route('stats.index') }}">Quiz Stats</a>
					</li>
					<li style="padding-right: 30px;" class="nav-item">
						<a class="nav-link" href="{{ route('quiz.index') }}">Quizzes</a>
					</li>
					<li style="padding-right: 30px;" class="nav-item">
						<a class="nav-link" href="{{ route('quiz.averages') }}">Quiz Average</a>
					</li>
					<li style="padding-right: 30px;" class="nav-item">
						<a class="nav-link" href="{{ route('users.averages') }}">User Average</a>
					</li>
				@endif
			@endauth

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<!-- Left Side Of Navbar -->
				<ul class="navbar-nav me-auto">

				</ul>

				<!-- Right Side Of Navbar -->
				<ul class="navbar-nav ms-auto">
					<!-- Authentication Links -->
					@guest
					@if (Route::has('login'))
					<li class="nav-item">
						<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
					</li>
					@endif

					@if (Route::has('register'))
					<li class="nav-item">
						<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
					</li>
					@endif
					@else
					<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
							{{ Auth::user()->name }}
						</a>

						<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</li>
					@endguest
				</ul>
			</div>
		</div>
	</nav>
	<div class="maincontent" style="text-align: center" style="position: fixed;">
		<canvas id="canvas"></canvas>
		<div class="mt-3">
			<button id="startStop" onclick="myfunc();" class="btn btn-primary">Start</button>
			<button id="exit" class="btn btn-danger">Exit</button>
		</div>
		<div class="mt-3">
			<p>Timer: <span id="timerDisplay">0</span></p>
			<p>Correct Moves: <span id="correct-moves">0</span></p>
			<p>Wrong Moves: <span id="wrong-moves">0</span></p>
		</div>

		<script type="text/javascript">
			var gameover = 0;
			var moves = new Array();
			var rect;
			var compl = 0;
			var phone = 0;
			var cor1 = 0;
			var wro1 = 0;
			var completed;
			var canvas = document.getElementById("canvas");
			var ctx = canvas.getContext("2d");
			var $canvas = $("#canvas");
			var scrollX = $canvas.scrollLeft();
			var scrollY = $canvas.scrollTop();
			ctx.canvas.width = window.innerWidth;
			ctx.canvas.height = window.innerHeight * 0.8;
			var cw = canvas.width;
			var ch = canvas.height;
			var w = cw / 100;
			var h = ch / 100;
			var isDown = false;
			var lastX;
			var lastY;
			var pos;
			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			const bars = {{ $quiz->number_of_discs}};
			var myhit = 0;
			var bar = 0;
			var bars1 = new Array();
			var colors = [
				'#ff80ed',
				'#008080',
				'#ff0000',
				'#ffd700',
				'#ff7373',
				'#0000ff',
				'#00ff00',
				'#66cdaa',
				'#f08080',
				'#20b2aa',
				'#cccccc',
				'#ff6666'
			];
			for (i = 0; i < bars; i++) bars1.push([w * (7 + i), h * (95 - i * 5), w * (24 - i * 2), h * 5, colors[i], i + 1]);
			var bars2 = new Array();
			var bars3 = new Array();
			var len1 = bars1.length - 1;
			var len2 = bars2.length - 1;
			var len3 = bars3.length - 1;
			var current;
			var clin0, clin1;

			function canv() {
				ctx.clearRect(0, 0, cw, ch);
				for (i = 0; i < bars1.length; i++) {
					bars1[i][0] /= w;
					bars1[i][1] /= h;
					bars1[i][2] /= w;
					bars1[i][3] /= h;
				}

				for (i = 0; i < bars2.length; i++) {
					bars2[i][0] /= w;
					bars2[i][1] /= h;
					bars2[i][2] /= w;
					bars2[i][3] /= h;
				}
				for (i = 0; i < bars3.length; i++) {
					bars3[i][0] /= w;
					bars3[i][1] /= h;
					bars3[i][2] /= w;
					bars3[i][3] /= h;
				}

				cw = document.getElementById('canvas').width = window.innerWidth;
				ch = document.getElementById('canvas').height = window.innerHeight * 0.8;
				w = cw / 100;
				h = ch / 100;

				for (i = 0; i < bars1.length; i++) {
					bars1[i][0] *= w;
					bars1[i][1] *= h;
					bars1[i][2] *= w;
					bars1[i][3] *= h;
				}

				for (i = 0; i < bars2.length; i++) {
					bars2[i][0] *= w;
					bars2[i][1] *= h;
					bars2[i][2] *= w;
					bars2[i][3] *= h;
				}
				for (i = 0; i < bars3.length; i++) {
					bars3[i][0] *= w;
					bars3[i][1] *= h;
					bars3[i][2] *= w;
					bars3[i][3] *= h;
				}
				drawAll();

			}

			function drawAll() {
				ctx.font = '2vh serif';
				ctx.clearRect(0, 0, cw, ch);

				ctx.fillStyle = "#00FFFF";
				ctx.fillRect(w * 7, 0, w * 24, h * 100);
				ctx.fillRect(w * 38, 0, w * 24, h * 100);
				ctx.fillRect(w * 69, 0, w * 24, h * 100);

				ctx.textAlign = "center";
				for (i = 0; i < bars1.length; i++) {
					ctx.fillStyle = bars1[i][4];
					ctx.fillRect(bars1[i][0], bars1[i][1], bars1[i][2], bars1[i][3]);
					ctx.fillStyle = "#000000";
					ctx.fillText(bars1[i][5], bars1[i][0] + (bars1[i][2] - w) / 2, (bars1[i][1] + (bars1[i][1] + 2 * h + bars1[i][3])) / 2);
				}

				for (i = 0; i < bars2.length; i++) {
					ctx.fillStyle = bars2[i][4];
					ctx.fillRect(bars2[i][0], bars2[i][1], bars2[i][2], bars2[i][3]);
					ctx.fillStyle = "#000000";
					ctx.fillText(bars2[i][5], bars2[i][0] + (bars2[i][2] - w) / 2, (bars2[i][1] + (bars2[i][1] + 2 * h + bars2[i][3])) / 2);
				}

				for (i = 0; i < bars3.length; i++) {
					ctx.fillStyle = bars3[i][4];
					ctx.fillRect(bars3[i][0], bars3[i][1], bars3[i][2], bars3[i][3]);
					ctx.fillStyle = "#000000";
					ctx.fillText(bars3[i][5], bars3[i][0] + (bars3[i][2] - w) / 2, (bars3[i][1] + (bars3[i][1] + 2 * h + bars3[i][3])) / 2);
				}
			}


			function myfunc() {


				drawAll();

				function addCorrect() {
					cor1++;
					document.getElementById("correct-moves").innerText=cor1;
				}

				function addWrong() {
					wro1++;
					document.getElementById("wrong-moves").innerText=wro1;
				}

				function handleMouseDown(e) {
					rect = canvas.getBoundingClientRect();

					if (over == 1) return;
					e.preventDefault();
					e.stopPropagation();
					if (phone == 0) {
						lastX = (e.clientX - rect.left);
						lastY = (e.clientY - rect.top);
					} else {
						lastX = (e.touches[0].clientX - rect.left);
						lastY = (e.touches[0].clientY - rect.top);
					}


					if (len1 >= 0) {
						if (lastX >= bars1[len1][0] && lastX <= (bars1[len1][2] + bars1[len1][0]) && lastY >= bars1[len1][1] && lastY <= (bars1[len1][1] + h * 5)) {
							bar = 1;
							pos = len1;
							myhit = 1;
							isDown = true;
							clin0 = bars1[bars1.length - 1][0];
							clin1 = bars1[bars1.length - 1][1];

						}
					}
					if (len2 >= 0) {
						if (lastX >= bars2[len2][0] && lastX <= (bars2[len2][2] + bars2[len2][0]) && lastY >= bars2[len2][1] && lastY <= (bars2[len2][1] + h * 5)) {
							bar = 2;
							pos = len2;
							myhit = 1;
							isDown = true;
							clin0 = bars2[bars2.length - 1][0];
							clin1 = bars2[bars2.length - 1][1];
						}
					}
					if (len3 >= 0) {
						if (lastX >= bars3[len3][0] && lastX <= (bars3[len3][2] + bars3[len3][0]) && lastY >= bars3[len3][1] && lastY <= (bars3[len3][1] + h * 5)) {
							bar = 3;
							pos = len3;
							myhit = 1;
							isDown = true;
							clin0 = bars3[bars3.length - 1][0];
							clin1 = bars3[bars3.length - 1][1];
						}
					}
				}

				function handleMouseUp(e) {
					rect = canvas.getBoundingClientRect();
					e.preventDefault();
					e.stopPropagation();

					if (phone == 0) {
						lastX = (e.clientX - rect.left);
						lastY = (e.clientY - rect.top);
					} else {
						lastX = (e.touches[0].clientX - rect.left);
						lastY = (e.touches[0].clientY - rect.top);
					}

					if (myhit == 1 && bar == 1) {
						if (lastX >= w * 69 && lastX <= w * 93 && (bars3.length == 0 || bars3[bars3.length - 1][2] > bars1[bars1.length - 1][2])) {
							bars3.push(bars1[len1]);
							bars3[bars3.length - 1][0] = w * 81 - bars3[bars3.length - 1][2] / 2;
							len1--;
							len3++;
							bars1.pop();
							bars3[bars3.length - 1][1] = h * 95 - 5 * h * (bars3.length - 1);
							addCorrect();
							moves.push(['A to C', 'correct']);
						} else if (lastX >= w * 38 && lastX <= w * 62 && (bars2.length == 0 || bars2[bars2.length - 1][2] > bars1[bars1.length - 1][2])) {
							bars2.push(bars1[len1]);
							bars2[bars2.length - 1][0] = w * 50 - bars2[bars2.length - 1][2] / 2;
							len1--;
							len2++;
							bars1.pop();
							bars2[bars2.length - 1][1] = h * 95 - 5 * h * (bars2.length - 1);
							addCorrect();
							moves.push(['A to B', 'correct']);
						} else {
							bars1[bars1.length - 1][0] = clin0;
							bars1[bars1.length - 1][1] = clin1;
							if (lastX >= w * 38 && lastX <= w * 62) {
								addWrong();
								moves.push(['A to B', 'incorrect']);
							}
							if (lastX >= w * 69 && lastX <= w * 93) {
								addWrong();
								moves.push(['A to C', 'incorrect']);
							}
						}
					}

					if (myhit == 1 && bar == 2) {
						if (lastX >= w * 69 && lastX <= w * 93 && (bars3.length == 0 || bars3[bars3.length - 1][2] > bars2[bars2.length - 1][2])) {
							bars3.push(bars2[len2]);
							bars3[bars3.length - 1][0] = w * 81 - bars3[bars3.length - 1][2] / 2;
							len2--;
							len3++;
							bars2.pop();
							bars3[bars3.length - 1][1] = h * 95 - 5 * h * (bars3.length - 1);
							addCorrect();
							moves.push(['B to C', 'correct']);
						} else if (lastX >= w * 7 && lastX <= w * 31 && (bars1.length == 0 || bars1[bars1.length - 1][2] > bars2[bars2.length - 1][2])) {
							bars1.push(bars2[len2]);
							bars1[bars1.length - 1][0] = w * 19 - bars1[bars1.length - 1][2] / 2;
							len2--;
							len1++;
							bars2.pop();
							bars1[bars1.length - 1][1] = h * 95 - 5 * h * (bars1.length - 1);
							addCorrect();
							moves.push(['B to A', 'correct']);
						} else {
							bars2[bars2.length - 1][0] = clin0;
							bars2[bars2.length - 1][1] = clin1;
							if (lastX >= w * 7 && lastX <= w * 31) {
								addWrong();
								moves.push(['B to A', 'incorrect']);
							}
							if (lastX >= w * 69 && lastX <= w * 93) {
								addWrong();
								moves.push(['B to C', 'incorrect']);
							}
						}
					}

					if (myhit == 1 && bar == 3) {
						if (lastX >= w * 7 && lastX <= w * 31 && (bars1.length == 0 || bars1[bars1.length - 1][2] > bars3[bars3.length - 1][2])) {
							bars1.push(bars3[len3]);
							bars1[bars1.length - 1][0] = w * 19 - bars1[bars1.length - 1][2] / 2;
							len3--;
							len1++;
							bars3.pop();
							bars1[bars1.length - 1][1] = h * 95 - 5 * h * (bars1.length - 1);
							addCorrect();
							moves.push(['C to A', 'correct']);
						} else if (lastX >= w * 38 && lastX <= w * 62 && (bars2.length == 0 || bars2[bars2.length - 1][2] > bars3[bars3.length - 1][2])) {
							bars2.push(bars3[len3]);
							bars2[bars2.length - 1][0] = w * 50 - bars2[bars2.length - 1][2] / 2;
							len3--;
							len2++;
							bars3.pop();
							bars2[bars2.length - 1][1] = h * 95 - 5 * h * (bars2.length - 1);
							addCorrect();
							moves.push(['C to B', 'correct']);
						} else {
							bars3[bars3.length - 1][0] = clin0;
							bars3[bars3.length - 1][1] = clin1;
							if (lastX >= w * 38 && lastX <= w * 62) {
								addWrong();
								moves.push(['C to B', 'incorrect']);
							}
							if (lastX >= w * 7 && lastX <= w * 31) {
								addWrong();
								moves.push(['C to A', 'incorrect']);
							}
						}
					}
					myhit = 0;
					isDown = false;

					drawAll();
					if (bars1.length == 0 && (bars2.length == 0 || bars3.length == 0)) {
						compl = 1;
						endfunc();
					}
				}

				function handleMouseMove(e) {
					rect = canvas.getBoundingClientRect();
					if (!isDown) {
						return;
					}
					e.preventDefault();
					e.stopPropagation();

					if (myhit == 1) {
						if (bar == 1) {

							if (phone == 0) {
								bars1[pos][0] = bars1[pos][0] + (e.clientX - rect.left - lastX);
								bars1[pos][1] = bars1[pos][1] + (e.clientY - rect.top - lastY);
								lastX = (e.clientX - rect.left);
								lastY = (e.clientY - rect.top);
							} else {
								bars1[pos][0] = bars1[pos][0] + (e.touches[0].clientX - rect.left - lastX);
								bars1[pos][1] = bars1[pos][1] + (e.touches[0].clientY - rect.top - lastY);
								lastX = (e.touches[0].clientX - rect.left);
								lastY = (e.touches[0].clientY - rect.top);
							}
						}
						if (bar == 2) {

							if (phone == 0) {
								bars2[pos][0] = bars2[pos][0] + (e.clientX - rect.left - lastX);
								bars2[pos][1] = bars2[pos][1] + (e.clientY - rect.top - lastY);
								lastX = (e.clientX - rect.left);
								lastY = (e.clientY - rect.top);
							} else {
								bars2[pos][0] = bars2[pos][0] + (e.touches[0].clientX - rect.left - lastX);
								bars2[pos][1] = bars2[pos][1] + (e.touches[0].clientY - rect.top - lastY);
								lastX = (e.touches[0].clientX - rect.left);
								lastY = (e.touches[0].clientY - rect.top);
							}
						}
						if (bar == 3) {

							if (phone == 0) {
								bars3[pos][0] = bars3[pos][0] + (e.clientX - rect.left - lastX);
								bars3[pos][1] = bars3[pos][1] + (e.clientY - rect.top - lastY);
								lastX = (e.clientX - rect.left);
								lastY = (e.clientY - rect.top);
							} else {
								bars3[pos][0] = bars3[pos][0] + (e.touches[0].clientX - rect.left - lastX);
								bars3[pos][1] = bars3[pos][1] + (e.touches[0].clientY - rect.top - lastY);
								lastX = (e.touches[0].clientX - rect.left);
								lastY = (e.touches[0].clientY - rect.top);
							}
						}
						drawAll();
					}
				}

				$("#canvas").mousedown(function(e) {
					phone = 0;
					if (gameover == 0)
						handleMouseDown(e);
				});
				$("#canvas").mousemove(function(e) {
					phone = 0;
					if (gameover == 0)
						handleMouseMove(e);
				});
				$("#canvas").mouseup(function(e) {
					phone = 0;
					if (gameover == 0)
						handleMouseUp(e);
				});
				$("#canvas").mouseout(function(e) {
					phone = 0;
					if (gameover == 0)
						handleMouseUp(e);
				});
				canvas.addEventListener("touchstart", function(e) {
					phone = 1;
					handleMouseDown(e);
				}, false);
				canvas.addEventListener("touchmove", function(e) {
					phone = 1;
					handleMouseMove(e);
				}, false);
				canvas.addEventListener("touchend", function(e) {
					phone = 1;
					handleMouseUp(e);

				}, false);

			}


			function endfunc() {
				gameover = 1;
				if (compl == 1) {
					completed='success';
					ctx.font = "50px Arial";
					ctx.fillStyle = "green";
					ctx.textAlign = "center";
					ctx.fillText("Success", canvas.width / 2, canvas.height / 2);
				} else {
					completed='fail';
					ctx.font = "50px Arial";
					ctx.fillStyle = "red";
					ctx.textAlign = "center";
					ctx.fillText("Fail", canvas.width / 2, canvas.height / 2);
				}

				var move = document.getElementById('text4');
				var com = document.getElementById('text5');
				com.value = compl;
				clearInterval(interval);
				document.getElementById('sub').hidden = false;
				var myJsonString = JSON.stringify(moves);
				move.value = myJsonString;
				over = 1;
				document.getElementById('end').hidden = true;
			}

			let timer;
			let isRunning = false;
			let gameInProgress = false;
			const startStopBtn = document.getElementById('startStop');
			const exitBtn = document.getElementById('exit');
			startStopBtn.addEventListener('click', function() {
				if (!gameInProgress) {
					startGame();
				} else if (isRunning) {
					stopGame();
				} else {
					submitGame();
				}
			});

			function startGame() {
				startTimer();
				startStopBtn.innerText = 'Stop';
				gameInProgress = true;
				isRunning = true;

			}

			function stopGame() {
				stopTimer();
				startStopBtn.innerText = 'Submit';
				isRunning = false;
				endfunc();
			}

			function submitGame() {
				// Submit the game data to the database
				let timePlayed = getTimePlayed();
				let quizId = {{ $quiz->id }};
				//alert(correctMoves + " " +wrongMoves + " " +timePlayed +" " + playerId +" " + quizId);
				// Submit the data using an AJAX POST request

				const data = {
					correct_moves: cor1,
					wrong_moves: wro1,
					time_played: timePlayed,
					quiz_id: quizId,
					completed: completed
				};

				$.ajax({
					url: "{{ route('submit') }}",
					type: 'POST',
					data: JSON.stringify(data),
					contentType: 'application/json',
					dataType: 'json',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(response) {
						$('#result').html('<p>' + response.message + '</p>');
					},
					error: function(xhr, status, error) {
						console.log(xhr);
						console.log(status);
						console.log(error);
					}
				});
			}
			var total = 0;

			function startTimer() {
				let startTime = Date.now();
				let timerDisplay = document.getElementById('timerDisplay');

				timer = setInterval(function() {
					let elapsedTime = Date.now() - startTime;
					let totalSeconds = Math.floor(elapsedTime / 1000);
					total = totalSeconds;
					timerDisplay.innerText = totalSeconds;
				}, 1000);
			}

			function stopTimer() {
				clearInterval(timer);
			}

			function getTimePlayed() {
				let timerDisplay = document.getElementById('timerDisplay');
				let totalSeconds = total;
				return totalSeconds;
			}


			exitBtn.addEventListener('click', function() {
				// Redirect to another page or close the window
				window.location.href = '/quiz';
			});
		</script>
	</div>


</body>

</html>