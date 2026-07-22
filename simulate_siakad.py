import asyncio
import shutil
import os
from playwright.async_api import async_playwright

BASE_URL = "http://localhost:8000"

async def wait(page, seconds=1.5):
    await page.wait_for_timeout(int(seconds * 1000))

async def scroll_smooth(page, amount=300):
    await page.evaluate(f"window.scrollBy({{top: {amount}, behavior: 'smooth'}})")
    await wait(page, 0.8)

async def scroll_top(page):
    await page.evaluate("window.scrollTo({top: 0, behavior: 'smooth'})")
    await wait(page, 0.5)

async def run():
    async with async_playwright() as p:
        browser = await p.chromium.launch(
            headless=False,
            slow_mo=80,
            channel="chrome",
            executable_path=r"C:\Users\LENOVO\AppData\Local\Google\Chrome\Application\chrome.exe"
        )
        context = await browser.new_context(
            viewport={"width": 1280, "height": 800},
            record_video_dir=".",
            record_video_size={"width": 1280, "height": 800},
        )
        page = await context.new_page()

        print("1. Grid Jadwal Mingguan...")
        await page.goto(BASE_URL, wait_until="networkidle")
        await wait(page, 2.5)
        await scroll_smooth(page, 250)
        await wait(page, 1.5)
        await scroll_top(page)
        await wait(page, 1)

        kelas_select = page.locator('select[name="kelas"]').first
        kelas_opts = await kelas_select.locator("option").all_text_contents()
        if len(kelas_opts) > 1:
            await kelas_select.select_option(index=1)
            await wait(page, 0.5)
            await page.locator('button[type="submit"]').first.click()
            await page.wait_for_load_state("networkidle")
            await wait(page, 2)
            await page.locator('a.btn.btn-secondary', has_text="Reset").first.click()
            await page.wait_for_load_state("networkidle")
            await wait(page, 1.5)

        sem_select = page.locator('select[name="semester"]').first
        sem_opts = await sem_select.locator("option").all_text_contents()
        if len(sem_opts) > 1:
            await sem_select.select_option(index=1)
            await wait(page, 0.5)
            await page.locator('button[type="submit"]').first.click()
            await page.wait_for_load_state("networkidle")
            await wait(page, 2)
            await page.locator('a.btn.btn-secondary', has_text="Reset").first.click()
            await page.wait_for_load_state("networkidle")
            await wait(page, 1.5)

        print("2. Jadwal List View...")
        await page.locator('a.nav-item', has_text="Jadwal").first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 2)
        await scroll_smooth(page, 300)
        await wait(page, 1)
        await scroll_top(page)

        prodi_sel = page.locator('select[name="prodi"]')
        if await prodi_sel.count() > 0:
            prodi_opts = await prodi_sel.locator("option").all_text_contents()
            if len(prodi_opts) > 1:
                await prodi_sel.select_option(index=1)
                await wait(page, 0.5)
                await page.locator('button[type="submit"]').first.click()
                await page.wait_for_load_state("networkidle")
                await wait(page, 2)
                await page.locator('a.btn.btn-secondary', has_text="Reset").first.click()
                await page.wait_for_load_state("networkidle")
                await wait(page, 1.5)

        print("3. Tambah Jadwal...")
        await page.locator('a.btn.btn-primary', has_text="Tambah").first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 1.5)

        mk_sel = page.locator('select[name="mata_kuliah_id"]')
        if await mk_sel.count() > 0:
            opts = await mk_sel.locator("option").all_text_contents()
            if len(opts) > 1:
                await mk_sel.select_option(index=1)
                await wait(page, 0.4)

        dosen_sel = page.locator('select[name="dosen_id"]')
        if await dosen_sel.count() > 0:
            opts = await dosen_sel.locator("option").all_text_contents()
            if len(opts) > 1:
                await dosen_sel.select_option(index=1)
                await wait(page, 0.4)

        ruangan_sel = page.locator('select[name="ruangan_id"]')
        if await ruangan_sel.count() > 0:
            opts = await ruangan_sel.locator("option").all_text_contents()
            if len(opts) > 1:
                await ruangan_sel.select_option(index=1)
                await wait(page, 0.4)

        hari_sel = page.locator('select[name="hari"]')
        if await hari_sel.count() > 0:
            await hari_sel.select_option("Senin")
            await wait(page, 0.4)

        await page.locator('input[name="mulai"]').fill("14:00")
        await wait(page, 0.3)
        await page.locator('input[name="selesai"]').fill("15:30")
        await wait(page, 0.3)
        await page.locator('input[name="kelas"]').fill("TI-5A")
        await wait(page, 0.3)

        sem_input = page.locator('input[name="semester"]')
        sem_sel2 = page.locator('select[name="semester"]')
        if await sem_input.count() > 0:
            await sem_input.fill("Ganjil 2025/2026")
        elif await sem_sel2.count() > 0:
            opts = await sem_sel2.locator("option").all_text_contents()
            if len(opts) > 1:
                await sem_sel2.select_option(index=1)

        await wait(page, 0.5)
        await scroll_smooth(page, 200)
        await wait(page, 0.5)
        await page.locator('button[type="submit"]').first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 2.5)

        print("4. Validasi Bentrok...")
        await page.locator('a.btn.btn-primary', has_text="Tambah").first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 1.5)

        mk_sel2 = page.locator('select[name="mata_kuliah_id"]')
        if await mk_sel2.count() > 0:
            opts = await mk_sel2.locator("option").all_text_contents()
            if len(opts) > 1:
                await mk_sel2.select_option(index=1)
                await wait(page, 0.4)

        dosen_sel2 = page.locator('select[name="dosen_id"]')
        if await dosen_sel2.count() > 0:
            opts = await dosen_sel2.locator("option").all_text_contents()
            if len(opts) > 1:
                await dosen_sel2.select_option(index=1)
                await wait(page, 0.4)

        ruangan_sel2 = page.locator('select[name="ruangan_id"]')
        if await ruangan_sel2.count() > 0:
            opts = await ruangan_sel2.locator("option").all_text_contents()
            if len(opts) > 1:
                await ruangan_sel2.select_option(index=1)
                await wait(page, 0.4)

        hari_sel2 = page.locator('select[name="hari"]')
        if await hari_sel2.count() > 0:
            await hari_sel2.select_option("Senin")
            await wait(page, 0.4)

        await page.locator('input[name="mulai"]').fill("14:30")
        await wait(page, 0.3)
        await page.locator('input[name="selesai"]').fill("16:00")
        await wait(page, 0.3)
        await page.locator('input[name="kelas"]').fill("TI-5B")
        await wait(page, 0.3)

        sem_input3 = page.locator('input[name="semester"]')
        sem_sel3 = page.locator('select[name="semester"]')
        if await sem_input3.count() > 0:
            await sem_input3.fill("Ganjil 2025/2026")
        elif await sem_sel3.count() > 0:
            opts = await sem_sel3.locator("option").all_text_contents()
            if len(opts) > 1:
                await sem_sel3.select_option(index=1)

        await wait(page, 0.5)
        await scroll_top(page)
        await wait(page, 0.5)
        await page.locator('button[type="submit"]').first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 3.5)

        print("5. Edit Jadwal...")
        await page.goto(f"{BASE_URL}/jadwal", wait_until="networkidle")
        await wait(page, 1.5)
        edit_btn = page.locator('a.btn.btn-warning', has_text="Edit").first
        if await edit_btn.count() > 0:
            await edit_btn.click()
            await page.wait_for_load_state("networkidle")
            await wait(page, 1.5)
            kelas_inp = page.locator('input[name="kelas"]')
            if await kelas_inp.count() > 0:
                await kelas_inp.triple_click()
                await kelas_inp.fill("TI-6A")
                await wait(page, 0.5)
            await page.locator('button[type="submit"]').first.click()
            await page.wait_for_load_state("networkidle")
            await wait(page, 2)

        print("6. Export CSV...")
        await page.goto(f"{BASE_URL}/jadwal", wait_until="networkidle")
        await wait(page, 1)
        export_btn = page.locator('a.btn.btn-success').first
        if await export_btn.count() > 0:
            await export_btn.hover()
            await wait(page, 1)
            try:
                async with page.expect_download(timeout=8000) as dl:
                    await export_btn.click()
                download = await dl.value
                print(f"   CSV: {download.suggested_filename}")
            except Exception as e:
                print(f"   Export note: {e}")
            await wait(page, 2)

        print("7. CRUD Dosen...")
        await page.goto(f"{BASE_URL}/dosen", wait_until="networkidle")
        await wait(page, 2)
        await scroll_smooth(page, 200)
        await wait(page, 1)
        await scroll_top(page)
        await page.locator('a.btn.btn-primary', has_text="Tambah").first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 1.5)
        await page.locator('input[name="nama"]').fill("Dr. Ahmad Fauzi, M.Kom")
        await wait(page, 0.3)
        await page.locator('input[name="nidn"]').fill("0099887766")
        await wait(page, 0.3)
        await page.locator('input[name="email"]').fill("ahmad.fauzi@kalla.ac.id")
        await wait(page, 0.5)
        await page.locator('button[type="submit"]').first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 2)
        edit_dosen = page.locator('a.btn.btn-warning', has_text="Edit").first
        if await edit_dosen.count() > 0:
            await edit_dosen.click()
            await page.wait_for_load_state("networkidle")
            await wait(page, 1.5)
            nama_inp = page.locator('input[name="nama"]')
            await nama_inp.triple_click()
            await nama_inp.fill("Dr. Ahmad Fauzi, S.T., M.Kom")
            await wait(page, 0.5)
            await page.locator('button[type="submit"]').first.click()
            await page.wait_for_load_state("networkidle")
            await wait(page, 2)

        print("8. CRUD Mata Kuliah...")
        await page.goto(f"{BASE_URL}/mata-kuliah", wait_until="networkidle")
        await wait(page, 2)
        await page.locator('a.btn.btn-primary', has_text="Tambah").first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 1.5)
        await page.locator('input[name="kode"]').fill("IF701")
        await wait(page, 0.3)
        await page.locator('input[name="nama"]').fill("Machine Learning")
        await wait(page, 0.3)
        sks_inp = page.locator('input[name="sks"]')
        if await sks_inp.count() > 0:
            await sks_inp.fill("3")
            await wait(page, 0.3)
        prodi_mk = page.locator('select[name="prodi_id"]')
        if await prodi_mk.count() > 0:
            opts = await prodi_mk.locator("option").all_text_contents()
            if len(opts) > 1:
                await prodi_mk.select_option(index=1)
                await wait(page, 0.3)
        await wait(page, 0.5)
        await page.locator('button[type="submit"]').first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 2)

        print("9. CRUD Ruangan...")
        await page.goto(f"{BASE_URL}/ruangan", wait_until="networkidle")
        await wait(page, 2)
        await page.locator('a.btn.btn-primary', has_text="Tambah").first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 1.5)
        await page.locator('input[name="kode"]').fill("RK-301")
        await wait(page, 0.3)
        await page.locator('input[name="nama"]').fill("Ruang Kuliah 301")
        await wait(page, 0.3)
        kap_inp = page.locator('input[name="kapasitas"]')
        if await kap_inp.count() > 0:
            await kap_inp.fill("40")
            await wait(page, 0.3)
        gedung_inp = page.locator('input[name="gedung"]')
        if await gedung_inp.count() > 0:
            await gedung_inp.fill("Gedung C")
            await wait(page, 0.3)
        await wait(page, 0.5)
        await page.locator('button[type="submit"]').first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 2)

        print("10. Hapus Ruangan RK-301...")
        await page.goto(f"{BASE_URL}/ruangan", wait_until="networkidle")
        await wait(page, 1.5)
        rows = page.locator("table tbody tr")
        row_count = await rows.count()
        for i in range(row_count):
            row_text = await rows.nth(i).text_content()
            if "RK-301" in (row_text or ""):
                hapus_btn = rows.nth(i).locator('button.btn-danger').first
                if await hapus_btn.count() > 0:
                    page.on("dialog", lambda d: asyncio.ensure_future(d.accept()))
                    await hapus_btn.click()
                    await page.wait_for_load_state("networkidle")
                    await wait(page, 2)
                break

        print("11. Grid Jadwal Akhir...")
        await page.locator('a.nav-item', has_text="Grid Jadwal").first.click()
        await page.wait_for_load_state("networkidle")
        await wait(page, 2)
        await scroll_smooth(page, 300)
        await wait(page, 1.5)
        await scroll_top(page)
        await wait(page, 3.5)

        print("Menyimpan video...")
        video_path = await page.video.path()
        print(f"Video path: {video_path}")

        await context.close()
        await browser.close()

        dest = r"c:\laragon\www\SIAKAD\siakad_demo.webm"
        if os.path.exists(video_path):
            shutil.copy2(video_path, dest)
            print(f"DONE: Video tersimpan di {dest}")
        else:
            print(f"ERROR: {video_path} tidak ditemukan")

asyncio.run(run())
