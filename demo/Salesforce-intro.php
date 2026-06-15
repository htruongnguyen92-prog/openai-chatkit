<?php
/**
 * Salesforce-intro.php – Interaktiver Rundgang über die Salesforce Case-Seite (Vorgang)
 * Eigenständige Seite für sf-dashboards/ · verlinkt aus der Kachel im Mitarbeiter-Portal
 *
 * Schritt-Inhalte werden serverseitig gepflegt und an das Frontend übergeben.
 * Beim Weiterklicken wird jeweils ein Element der Oberfläche hervorgehoben
 * und rechts mit wenig Text erklärt.
 */

$steps = [
  [
    'target' => 'nav',
    'title'  => 'Die Navigationsleiste',
    'text'   => 'Oben wechselst du zwischen den Bereichen – z. B. Konten, Vorgänge oder Berichte. Hier befinden wir uns gerade in einem <b>Vorgang</b> (engl. „Case").',
  ],
  [
    'target' => 'highlights',
    'title'  => 'Der Kopfbereich',
    'text'   => 'Auf einen Blick das Wichtigste: <b>Vorgangsnummer</b>, Betreff und die zentralen Felder. So weißt du sofort, worum es geht.',
  ],
  [
    'target' => 'path',
    'title'  => 'Der Status-Pfad',
    'text'   => 'Zeigt, in welcher <b>Phase</b> der Vorgang steckt – von „Neu" bis „Abgeschlossen". Jeder im Team sieht den aktuellen Stand.',
  ],
  [
    'target' => 'actions',
    'title'  => 'Aktionen',
    'text'   => 'Schnellzugriffe: <b>Bearbeiten</b>, dem Vorgang <b>Folgen</b> oder ihn <b>schließen</b>. Die wichtigsten Handgriffe immer griffbereit.',
  ],
  [
    'target' => 'details',
    'title'  => 'Detailbereich',
    'text'   => 'Alle <b>Felder</b> zum Vorgang: Priorität, Zuständigkeit, verknüpfter Vertrag. Hier wird der Fall vollständig dokumentiert.',
  ],
  [
    'target' => 'activity',
    'title'  => 'Aktivitäten',
    'text'   => 'E-Mails, Anrufe und Aufgaben direkt am Vorgang festhalten. Die <b>Timeline</b> darunter zeigt lückenlos, was wann passiert ist.',
  ],
  [
    'target' => 'chatter',
    'title'  => 'Zusammenarbeit (Chatter)',
    'text'   => 'Interne Kommunikation mit <b>@Erwähnung</b> – statt verstreuter E-Mails. Die Info bleibt für immer beim richtigen Vorgang.',
  ],
  [
    'target' => 'related',
    'title'  => 'Verknüpfte Datensätze',
    'text'   => 'Rechts hängen <b>Kontakte, Dateien</b> und der Vertrag direkt am Vorgang. Kein Suchen – alles an einem Ort.',
  ],
];
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Salesforce-Rundgang: Die Vorgangs-Seite | NovumState</title>
<style>
  :root{
    --sf-blue:#0070d2; --sf-blue-dark:#005fb2; --sf-navy:#16325c;
    --sf-bg:#f3f2f2; --sf-border:#dddbda; --sf-text:#080707; --sf-weak:#54698d;
    --sf-green:#2e844a; --sf-amber:#fe9339; --radius:6px; --shadow:0 2px 8px rgba(0,0,0,.12);
    --panel-w:380px;
  }
  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}
  body{font-family:"Segoe UI","Helvetica Neue",Arial,sans-serif;background:var(--sf-bg);color:var(--sf-text);font-size:14px;line-height:1.45;}

  /* layout: stage (SF mock) + explanation panel */
  .layout{display:flex; min-height:100vh;}
  .stage{flex:1; min-width:0; padding-right:var(--panel-w);}
  .explain{
    position:fixed; top:0; right:0; width:var(--panel-w); height:100vh;
    background:#fff; border-left:1px solid var(--sf-border); box-shadow:-2px 0 12px rgba(0,0,0,.06);
    display:flex; flex-direction:column; z-index:700;
  }

  /* ---------- SF global header ---------- */
  .gh{background:var(--sf-navy); color:#fff; display:flex; align-items:center; gap:14px; padding:8px 16px;}
  .launcher{width:26px;height:26px;display:grid;grid-template-columns:repeat(3,5px);grid-template-rows:repeat(3,5px);gap:3px;opacity:.9;}
  .launcher span{background:#fff;border-radius:1px;}
  .app-name{font-weight:700;font-size:15px;}
  .gsearch{flex:1;max-width:440px;background:#fff;border-radius:18px;display:flex;align-items:center;gap:8px;padding:6px 14px;color:var(--sf-weak);}
  .gsearch input{border:0;outline:0;flex:1;font-size:13px;}
  .gh .sp{flex:1;}
  .gh .icons{display:flex;align-items:center;gap:14px;}
  .av{width:28px;height:28px;border-radius:50%;background:#1589ee;color:#fff;display:grid;place-items:center;font-weight:700;font-size:11px;}

  /* ---------- app nav ---------- */
  .nav{background:#fff;border-bottom:1px solid var(--sf-border);display:flex;align-items:center;padding:0 16px;gap:2px;box-shadow:0 1px 3px rgba(0,0,0,.05);}
  .nav .t{padding:11px 14px;font-weight:600;color:var(--sf-weak);border-bottom:3px solid transparent;white-space:nowrap;}
  .nav .t.active{color:var(--sf-blue);border-bottom-color:var(--sf-blue);}

  .wrap{padding:16px;}

  /* highlights panel */
  .highlights{background:#fff;border:1px solid var(--sf-border);border-radius:var(--radius);box-shadow:var(--shadow);padding:14px 18px;margin-bottom:14px;}
  .hl-top{display:flex;align-items:center;gap:14px;}
  .hl-icon{width:42px;height:42px;border-radius:8px;background:#f99120;display:grid;place-items:center;color:#fff;font-size:20px;flex-shrink:0;}
  .hl-meta small{color:var(--sf-weak);text-transform:uppercase;font-size:11px;letter-spacing:.04em;}
  .hl-meta h1{margin:2px 0 0;font-size:19px;}
  .hl-actions{margin-left:auto;display:flex;gap:8px;}
  .hl-fields{display:flex;gap:30px;margin-top:12px;padding-top:12px;border-top:1px solid #f0efef;flex-wrap:wrap;}
  .hl-fields .f small{display:block;color:var(--sf-weak);font-size:11px;}
  .hl-fields .f b{font-size:14px;}

  /* path */
  .path{display:flex;border-radius:4px;overflow:hidden;border:1px solid var(--sf-border);margin-top:12px;}
  .path .step{flex:1;text-align:center;padding:9px 4px;font-size:12px;font-weight:600;background:#f3f3f3;color:var(--sf-weak);}
  .path .step.done{background:#c9e7d2;color:#0a6b32;}
  .path .step.current{background:var(--sf-blue);color:#fff;}

  .cols{display:grid;grid-template-columns:1.4fr 1fr;gap:14px;}
  @media(max-width:1100px){.cols{grid-template-columns:1fr;}}

  .card{background:#fff;border:1px solid var(--sf-border);border-radius:var(--radius);box-shadow:var(--shadow);margin-bottom:14px;overflow:hidden;}
  .card-h{padding:11px 16px;border-bottom:1px solid var(--sf-border);font-weight:700;color:var(--sf-navy);display:flex;align-items:center;gap:8px;}
  .card-h .count{color:var(--sf-weak);font-weight:400;}
  .card-b{padding:12px 16px;}
  .row2{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0efef;}
  .row2:last-child{border:0;}
  .row2 span{color:var(--sf-weak);}

  /* activity tabs */
  .acts{display:flex;gap:6px;margin-bottom:10px;}
  .acts .a{flex:1;text-align:center;padding:8px;border:1px solid var(--sf-border);border-radius:5px;font-weight:600;color:var(--sf-weak);font-size:12px;}
  .acts .a.sel{color:var(--sf-blue);border-color:var(--sf-blue);background:#f3f9ff;}
  .timeline .ti{display:flex;gap:10px;padding:10px 0;border-bottom:1px solid #f0efef;}
  .timeline .ti:last-child{border:0;}
  .timeline .dot{width:30px;height:30px;border-radius:50%;display:grid;place-items:center;color:#fff;flex-shrink:0;font-size:13px;}
  .timeline .when{color:var(--sf-weak);font-size:12px;}

  .feed .fi{display:flex;gap:10px;padding:11px 0;border-bottom:1px solid #f0efef;}
  .feed .fi:last-child{border:0;}
  .mention{color:var(--sf-blue);font-weight:600;}

  .list .li{display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid #f0efef;}
  .list .li:last-child{border:0;}
  .list .ri{width:28px;height:28px;border-radius:6px;display:grid;place-items:center;color:#fff;font-size:12px;flex-shrink:0;}
  .list a{color:var(--sf-blue);text-decoration:none;font-weight:600;}

  .btn{border:1px solid var(--sf-border);background:#fff;color:var(--sf-blue);padding:6px 12px;border-radius:4px;font-weight:600;cursor:pointer;font-size:13px;}
  .btn-p{background:var(--sf-blue);color:#fff;border-color:var(--sf-blue);}

  /* ---------- spotlight ---------- */
  #dim{position:fixed;inset:0;background:rgba(8,7,7,.55);z-index:600;display:none;}
  #dim.on{display:block;}
  [data-step]{transition:box-shadow .2s, outline .2s;}
  .spot{position:relative;z-index:650;outline:3px solid var(--sf-blue);outline-offset:3px;border-radius:8px;box-shadow:0 0 0 6px rgba(0,112,210,.25),0 6px 24px rgba(0,0,0,.25)!important;background:#fff;}

  /* ---------- explanation panel ---------- */
  .ep-head{padding:20px 22px 14px;border-bottom:1px solid var(--sf-border);}
  .ep-head .logo{width:40px;height:40px;border-radius:9px;background:var(--sf-blue);display:grid;place-items:center;font-size:20px;margin-bottom:10px;}
  .ep-head h2{margin:0;font-size:16px;}
  .ep-head p{margin:4px 0 0;color:var(--sf-weak);font-size:12px;}
  .ep-body{flex:1;padding:22px;overflow:auto;}
  .ep-chapter{color:var(--sf-blue);font-weight:700;font-size:12px;letter-spacing:.05em;text-transform:uppercase;}
  .ep-body h3{margin:8px 0 12px;font-size:21px;line-height:1.25;}
  .ep-body .txt{font-size:15px;color:#3e3e3c;}
  .ep-foot{padding:16px 22px;border-top:1px solid var(--sf-border);}
  .progress{height:6px;background:#eceaea;border-radius:3px;overflow:hidden;margin-bottom:14px;}
  .progress .bar{height:100%;background:var(--sf-blue);transition:width .3s;}
  .ep-nav{display:flex;align-items:center;gap:10px;}
  .ep-nav .count{margin-right:auto;color:var(--sf-weak);font-size:13px;}
  .ep-nav .btn{padding:9px 18px;}

  .start-hint{background:#f3f9ff;border:1px solid #cfe5fb;border-radius:6px;padding:12px 14px;color:#054a91;font-size:13px;}
</style>
</head>
<body>
<div class="layout">

  <!-- ============ STAGE: Salesforce Case page ============ -->
  <div class="stage">
    <header class="gh" data-step="nav-extra">
      <div class="launcher"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>
      <div class="app-name">Vertragsmanagement</div>
      <div class="gsearch">🔍 <input placeholder="Suche…" /></div>
      <div class="sp"></div>
      <div class="icons">🔔 ✓ <div class="av">TN</div></div>
    </header>

    <nav class="nav" data-step="nav">
      <div class="t">🏠 Start</div>
      <div class="t">🏢 Konten</div>
      <div class="t active">🗂️ Vorgänge</div>
      <div class="t">📄 Verträge</div>
      <div class="t">📊 Berichte</div>
    </nav>

    <div class="wrap">

      <!-- highlights -->
      <div class="highlights" data-step="highlights">
        <div class="hl-top">
          <div class="hl-icon">🗂️</div>
          <div class="hl-meta">
            <small>Vorgang · 00012345</small>
            <h1>Wasserschaden – Lindenstr. 12, 2. OG</h1>
          </div>
          <div class="hl-actions" data-step="actions">
            <button class="btn">+ Folgen</button>
            <button class="btn">Bearbeiten</button>
            <button class="btn btn-p">Schließen</button>
          </div>
        </div>

        <div class="path" data-step="path">
          <div class="step done">Neu</div>
          <div class="step done">In Bearbeitung</div>
          <div class="step current">Warten auf Kunde</div>
          <div class="step">Abgeschlossen</div>
        </div>

        <div class="hl-fields">
          <div class="f"><small>Priorität</small><b>Hoch</b></div>
          <div class="f"><small>Status</small><b>Warten auf Kunde</b></div>
          <div class="f"><small>Zuständig</small><b>Anna Krause</b></div>
          <div class="f"><small>Kunde</small><b>Mustermann Immobilien GmbH</b></div>
        </div>
      </div>

      <div class="cols">
        <!-- left column -->
        <div>
          <div class="card" data-step="details">
            <div class="card-h">📝 Details</div>
            <div class="card-b">
              <div class="row2"><span>Vorgangsnummer</span><b>00012345</b></div>
              <div class="row2"><span>Betreff</span><b>Wasserschaden Bad, 2. OG</b></div>
              <div class="row2"><span>Gemeldet von</span><b>Stefan Müller</b></div>
              <div class="row2"><span>Eröffnet am</span><b>13.06.2026</b></div>
              <div class="row2"><span>Verknüpfter Vertrag</span><b>Mietvertrag Lindenstr. 12</b></div>
            </div>
          </div>

          <div class="card" data-step="activity">
            <div class="card-h">🕓 Aktivitäten</div>
            <div class="card-b">
              <div class="acts">
                <div class="a sel">✉️ E-Mail</div>
                <div class="a">📞 Anruf</div>
                <div class="a">✓ Aufgabe</div>
              </div>
              <div class="timeline">
                <div class="ti"><div class="dot" style="background:#f99120">AK</div><div><b>Anna Krause</b> hat Handwerker beauftragt<div class="when">heute, 09:14</div></div></div>
                <div class="ti"><div class="dot" style="background:#1589ee">TN</div><div><b>Truong N.</b> hat Foto-Anhänge ergänzt<div class="when">gestern, 16:40</div></div></div>
                <div class="ti"><div class="dot" style="background:#9050e9">SM</div><div><b>Stefan Müller</b> hat Vorgang per E-Mail gemeldet<div class="when">13.06., 08:02</div></div></div>
              </div>
            </div>
          </div>

          <div class="card" data-step="chatter">
            <div class="card-h">💬 Zusammenarbeit</div>
            <div class="card-b feed">
              <div class="fi"><div class="dot" style="background:#f99120;width:32px;height:32px;border-radius:50%;display:grid;place-items:center;color:#fff;flex-shrink:0">AK</div>
                <div><b>Anna Krause</b> <span class="when" style="color:var(--sf-weak);font-size:12px">· vor 20 Min.</span><br><span class="mention">@Truong</span> Handwerker kommt morgen um 10 Uhr.</div></div>
              <div class="fi"><div class="dot" style="background:#9050e9;width:32px;height:32px;border-radius:50%;display:grid;place-items:center;color:#fff;flex-shrink:0">SM</div>
                <div><b>Stefan Müller</b> <span class="when" style="color:var(--sf-weak);font-size:12px">· vor 1 Std.</span><br>Danke für die schnelle Rückmeldung! 👍</div></div>
            </div>
          </div>
        </div>

        <!-- right column / related -->
        <div data-step="related">
          <div class="card">
            <div class="card-h">👤 Kontakte <span class="count">(2)</span></div>
            <div class="card-b list">
              <div class="li"><div class="ri" style="background:#1589ee">SM</div><div><a href="#">Stefan Müller</a><br><span class="when" style="color:var(--sf-weak)">Geschäftsführer</span></div></div>
              <div class="li"><div class="ri" style="background:#9050e9">AK</div><div><a href="#">Anna Krause</a><br><span class="when" style="color:var(--sf-weak)">Buchhaltung</span></div></div>
            </div>
          </div>
          <div class="card">
            <div class="card-h">📎 Dateien <span class="count">(3)</span></div>
            <div class="card-b list">
              <div class="li"><div class="ri" style="background:#e8516a">PDF</div><a href="#">Schadensfoto_Bad.pdf</a></div>
              <div class="li"><div class="ri" style="background:#e8516a">PDF</div><a href="#">Kostenvoranschlag_Wagner.pdf</a></div>
              <div class="li"><div class="ri" style="background:#2a9d4a">XLS</div><a href="#">Schadenprotokoll.xlsx</a></div>
            </div>
          </div>
          <div class="card">
            <div class="card-h">📄 Verknüpfter Vertrag</div>
            <div class="card-b list">
              <div class="li"><div class="ri" style="background:#4bc076">📄</div><div><a href="#">Mietvertrag Lindenstr. 12</a><br><span class="when" style="color:var(--sf-weak)">Aktiv · bis 31.12.2027</span></div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ============ EXPLANATION PANEL ============ -->
  <aside class="explain">
    <div class="ep-head">
      <div class="logo">☁️</div>
      <h2>Die Vorgangs-Seite (Case)</h2>
      <p>Ein geführter Rundgang durch die Salesforce-Oberfläche</p>
    </div>
    <div class="ep-body" id="epBody">
      <div class="ep-chapter">Rundgang</div>
      <h3>Willkommen!</h3>
      <div class="txt">
        <p>Diese Seite zeigt einen typischen <b>Vorgang</b> in Salesforce – hier ein Wasserschaden.</p>
        <p>Klicke auf <b>Weiter</b>, um die Oberfläche Schritt für Schritt kennenzulernen. Jedes Element wird kurz erklärt.</p>
        <div class="start-hint">💡 Tipp: Mit den Pfeiltasten ← → kannst du ebenfalls navigieren.</div>
      </div>
    </div>
    <div class="ep-foot">
      <div class="progress"><div class="bar" id="bar" style="width:0%"></div></div>
      <div class="ep-nav">
        <span class="count" id="counter">Start</span>
        <button class="btn" id="back" style="visibility:hidden">Zurück</button>
        <button class="btn btn-p" id="next">Rundgang starten ▶</button>
      </div>
    </div>
  </aside>
</div>

<div id="dim"></div>

<script>
(function(){
  "use strict";
  var steps = <?php echo json_encode($steps, JSON_UNESCAPED_UNICODE); ?>;
  var i = -1; // -1 = intro screen
  var dim = document.getElementById('dim');
  var bar = document.getElementById('bar');
  var counter = document.getElementById('counter');
  var back = document.getElementById('back');
  var next = document.getElementById('next');
  var body = document.getElementById('epBody');
  var lastEl = null;

  function clearSpot(){ if(lastEl){ lastEl.classList.remove('spot'); lastEl = null; } }

  function render(){
    // intro
    if(i < 0){
      clearSpot(); dim.classList.remove('on');
      back.style.visibility = 'hidden';
      next.textContent = 'Rundgang starten ▶';
      counter.textContent = 'Start';
      bar.style.width = '0%';
      return;
    }
    var s = steps[i];
    dim.classList.add('on');
    clearSpot();
    var el = document.querySelector('[data-step="'+s.target+'"]');
    if(el){
      el.classList.add('spot'); lastEl = el;
      el.scrollIntoView({behavior:'smooth', block:'center'});
    }
    body.innerHTML =
      '<div class="ep-chapter">Schritt '+(i+1)+' von '+steps.length+'</div>'+
      '<h3>'+s.title+'</h3>'+
      '<div class="txt"><p>'+s.text+'</p></div>';
    back.style.visibility = 'visible';
    next.textContent = (i === steps.length-1) ? 'Fertig ✓' : 'Weiter →';
    counter.textContent = (i+1)+' / '+steps.length;
    bar.style.width = Math.round((i+1)/steps.length*100)+'%';
  }

  function goNext(){
    if(i >= steps.length-1){ // finish -> reset to intro
      i = -1; render(); return;
    }
    i++; render();
  }
  function goBack(){ if(i > -1){ i--; render(); } }

  next.addEventListener('click', goNext);
  back.addEventListener('click', goBack);
  document.addEventListener('keydown', function(e){
    if(e.key === 'ArrowRight') goNext();
    if(e.key === 'ArrowLeft') goBack();
  });
  // click on dim background advances too
  dim.addEventListener('click', goNext);

  render();
})();
</script>
</body>
</html>
