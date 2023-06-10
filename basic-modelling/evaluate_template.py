from modeller import *
from modeller.scripts import complete_pdb
import sys

log.verbose()    # request verbose output
env = Environ()
env.libs.topology.read(file='$(LIB)/top_heav.lib') # read topology
env.libs.parameters.read(file='$(LIB)/par.lib') # read parameters

# directories for input atom files
env.io.atom_files_directory = './:../atom_files'

# read model file
mdl = complete_pdb(env, 'Template.pdb', model_segment=('FIRST:'+sys.argv[1], 'LAST:'+sys.argv[1]))

s = Selection(mdl)
s.assess_dope(output='ENERGY_PROFILE NO_REPORT', file='Template'+sys.argv[1]+'.profile',
              normalize_profile=True, smoothing_window=15)
