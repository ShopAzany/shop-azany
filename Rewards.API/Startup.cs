using Application.Shared.Infrastructure.Bootstrapper;
using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Http;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Hosting;
using Microsoft.Extensions.Logging;
using Rewards.API.ApplicationConfigurationValidators;
using Rewards.API.ApplicationServices.ServiceExtensions;
using Rewards.Infrastructure;
using System.Threading.Tasks;

namespace Rewards.API
{
    public class Startup
    {
        public Startup(IWebHostEnvironment env)
        {
            var environment = env.IsDevelopment() ? "Development" : "Production";
            Configuration = new ConfigurationBuilder()
                .AddJsonFile($"appsettings.{environment}.json")
                .Build();
            Environment = env;
            ConfigurationValidator.RunValidators(Configuration);
        }


        public void ConfigureServices(IServiceCollection services)
        {
            services.AddMvc().AddControllersAsServices();
            services.AddTransient<IHttpContextAccessor, HttpContextAccessor>();
            services.AddCrossOriginRequestRules(Configuration);
            services.AddDeploymentAddressConfiguration(Configuration);
            services.AddControllers();
            services.AddSwaggerDocumentation();
            services.AddSecurityConfiguration();

            var applicationConfiguration = Configuration.ExtractCoreApplicationSettings(new LoggerFactory());
            _bootstrapper = new Bootstrapper(applicationConfiguration);
            _bootstrapper.RegisterModule<RewardsModule>();

            services.AddScoped<IApplication>((_) => _bootstrapper.Application);
        }

        public void Configure(IApplicationBuilder app, IWebHostEnvironment env)
        {
            if (env.IsDevelopment())
            {
                app.UseDeveloperExceptionPage();
            }
            else
            {
                app.UseHsts();
            }

            app.UseHttpsRedirection();

            app.UseSwaggerDocumentation();

            app.UseRouting();

            app.UseCors(ConfigurationNames.CROSS_ORIGIN_POLICY);

            app.UseCookies();

            app.UseAuthentication();

            app.UseAuthorization();

            Task.WaitAll(_bootstrapper.AddApplicationServiceAsync(app.ApplicationServices));

            app.UseEndpoints(endpoints => endpoints.MapControllers());
        }
        public IWebHostEnvironment Environment { get; }
        public IConfiguration Configuration { get; }

        private Bootstrapper _bootstrapper;
    }
}
